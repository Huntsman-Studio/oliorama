<?php

if (!defined('ABSPATH')) die('No direct access.');

if (!class_exists('HOTP')) require_once(__DIR__.'/hotp-php-master/hotp.php');
if (!class_exists('Base32')) require_once(__DIR__.'/Base32/Base32.php');

class Simba_TFA_Provider_TOTP {

	// @var Simba_Two_Factor_Authentication
	private $tfa;
	
	// @var String
	private $salt_prefix;
	
	// @var String
	private $pw_prefix;
	
	// @var Integer
	private $time_window_size;
	
	// @var Integer
	private $check_back_time_windows;
	
	// @var Integer
	private $check_forward_time_windows;
	
	// @var Integer
	private $otp_length = 6;
	
	// @var Integer
	private $emergency_codes_length = 8;
	
	// @var String
	public $default_hmac = 'totp';
	
	/**
	 * Class constructor
	 *
	 * @param Simba_Two_Factor_Authentication main plugin class
	 */
	public function __construct($tfa) {
		$this->tfa = $tfa;
		
		$this->otp_helper = new HOTP();
		
		$this->time_window_size = apply_filters('simbatfa_time_window_size', 30);
		$this->check_back_time_windows = apply_filters('simbatfa_check_back_time_windows', 2);
		$this->check_forward_time_windows = apply_filters('simbatfa_check_forward_time_windows', 1);
		$this->check_forward_counter_window = apply_filters('simbatfa_check_forward_counter_window', 20);
		
		$this->salt_prefix = defined('AUTH_SALT') ? AUTH_SALT : wp_salt('auth');
		$this->pw_prefix = defined('AUTH_KEY') ? AUTH_KEY : get_site_option('auth_key');
		
	}
	
	/**
	 * Generate the current code for a specified user
	 *
	 * @param $user_id Integer - WordPress user ID
	 *
	 * @return String|Boolean - false if not set up
	 */
	public function get_current_code($user_id) {
	
		$tfa_priv_key_64 = get_user_meta($user_id, 'tfa_priv_key_64', true);
		
		if (!$tfa_priv_key_64) return false;
		
		return $this->generateOTP($user_id, $tfa_priv_key_64);
	
	}

	public function print_default_hmac_radios() {
		
		$setting = $this->tfa->get_option('tfa_default_hmac');
		
		$setting = $setting === false || !$setting ? $this->default_hmac : $setting;
		
		$types = array('totp' => __('TOTP (time based - most common algorithm; used by Google Authenticator)', 'two-factor-authentication'), 'hotp' => __('HOTP (event based)', 'two-factor-authentication'));
		
		foreach ($types as $id => $name) {
			print '<input type="radio" id="tfa_default_hmac_'.esc_attr($id).'" name="tfa_default_hmac" value="'.$id.'" '.($setting == $id ? 'checked="checked"' :'').'> '.'<label for="tfa_default_hmac_'.esc_attr($id).'">'."$name</label><br>\n";
		}
	}
	
	public function generateOTP($user_ID, $key_b64, $length = 6, $counter = false) {
		
		$length = $length ? (int)$length : 6;
		
		$key = $this->decryptString($key_b64, $user_ID);
		$alg = $this->get_user_otp_algorithm($user_ID);
		
		if ('hotp' == $alg) {
			$db_counter = $this->getUserCounter($user_ID);
			
			$counter = $counter ? $counter : $db_counter;
			$otp_res = $this->otp_helper->generateByCounter($key, $counter);
		} else {
			//time() is supposed to be UTC
			$time = $counter ? $counter : time();
			$otp_res = $this->otp_helper->generateByTime($key, $this->time_window_size, $time);
		}
		$code = $otp_res->toHotp($length);
		
		return $code;
	}
	
	/**
	 * Generate a list of OTP codes based on the user, key and time window
	 *
	 * @param Integer $user_ID - user ID
	 * @param String  $key_b64 - the user's private key, in base64 format
	 *
	 * @return Array
	 */
	private function generate_otps_for_login_check($user_ID, $key_b64) {
		$key = trim($this->decryptString($key_b64, $user_ID));
		$alg = $this->get_user_otp_algorithm($user_ID);
		
		if ('totp' == $alg) {
			$otp_res = $this->otp_helper->generateByTimeWindow($key, $this->time_window_size, -1*$this->check_back_time_windows, $this->check_forward_time_windows);
		} elseif ('hotp' == $alg) {
			
			$counter = $this->getUserCounter($user_ID);
			
			$otp_res = array();
			
			for ($i = 0; $i < $this->check_forward_counter_window; $i++) {
				$otp_res[] = $this->otp_helper->generateByCounter($key, $counter+$i);
			}
		}
		return $otp_res;
	}
	
	
	/**
	 * Generate a private key for the user.
	 *
	 * @param Integer $user_id - WordPress user ID
	 * @param Boolean|String $key
	 *
	 * @return String
	 */
	public function addPrivateKey($user_id, $key = false) {
		
		// To work with Google Authenticator it has to be 10 bytes = 16 chars in base32
		$code = $key ? $key : strtoupper($this->randString(10));
		
		// Encrypt the key
		$code = $this->encryptString($code, $user_id);
		
		// Add private key to usermeta
		update_user_meta($user_id, 'tfa_priv_key_64', $code);
		
		$alg = $this->get_user_otp_algorithm($user_id);
		
		// This hook is used for generation of emergency codes to accompany the key
		do_action('simba_tfa_adding_private_key', $alg, $user_id, $code, $this);
		
		$this->changeUserAlgorithmTo($user_id, $alg);
		
		return $code;
	}
	
	// Port over keys that were encrypted with mcrypt and its non-compliant padding scheme, so that if the site is ever migrated to a server without mcrypt, they can still be decrypted
	public function potentially_port_private_keys() {
		
		$simba_tfa_priv_key_format = get_site_option('simba_tfa_priv_key_format', false);
		
		if ($simba_tfa_priv_key_format >= 1 || !function_exists('openssl_encrypt')) return;
		
		$attempts = 0;
		$successes = 0;
		
		error_log("TFA: Beginning attempt to port private key encryption over to openssl");
		
		global $wpdb;
		
		$sql = "SELECT user_id, meta_value FROM ".$wpdb->usermeta." WHERE meta_key = 'tfa_priv_key_64'";
		
		$user_results = $wpdb->get_results($sql);
		
		foreach ($user_results as $u) {
			$dec_openssl = $this->decryptString($u->meta_value, $u->user_id, true);
			
			$ported = false;
			if ('' == $dec_openssl) {
				
				$attempts++;
				
				$dec_default = $this->decryptString($u->meta_value, $u->user_id);
				
				if ('' != $dec_default) {
					
					$enc = $this->encryptString($dec_default, $u->user_id);
					
					if ($enc) {
						
						$ported = true;
						$successes++;
						update_user_meta($u->user_id, 'tfa_priv_key_64', $enc);
					}
				}
				
			}
			
			if ($ported) {
				error_log("TFA: Successfully ported the key for user with ID ".$u->user_id." over to openssl");
			} else {
				error_log("TFA: Failed to port the key for user with ID ".$u->user_id." over to openssl");
			}
		}
		
		if ($attempts == 0 || $successes > 0) update_site_option('simba_tfa_priv_key_format', 1);
		
	}
	
	public function getPrivateKeyPlain($enc, $user_ID) {
		$dec = $this->decryptString($enc, $user_ID);
		$this->potentially_port_private_keys();
		return $dec;
	}
	
	/**
	 * @param Array $codes - current list of codes (encrypted)
	 * @param Integer $user_ID - WP user ID
	 * @param Boolean $generate_if_empty - generate some new codes if the list is empty
	 *
	 * @return String - human-usable codes, separated by ', ' (or a human-readable message, if there were none)
	 */
	public function getPanicCodesString($codes, $user_ID, $generate_if_empty = false) {
		if (!is_array($codes)) return '<em>'.__('No emergency codes left. Sorry.', 'two-factor-authentication').'</em>';
		if ($generate_if_empty && empty($codes)) {
			$tfa_priv_key = get_user_meta($user_ID, 'tfa_priv_key_64', true);
			$algorithm = get_user_meta($user_ID, 'tfa_algorithm_type', true);
			do_action('simba_tfa_emergency_codes_empty', $algorithm, $user_ID, $tfa_priv_key, $this);
			$codes = get_user_meta($user_ID, 'simba_tfa_emergency_codes_64', true);
			if (!is_array($codes)) $codes = array();
		}
		
		$emergency_str = '';
		
		foreach ($codes as $p_code) {
			$emergency_str .= $this->decryptString($p_code, $user_ID).', ';
		}
		
		$emergency_str = rtrim($emergency_str, ', ');
		
		$emergency_str = $emergency_str ? $emergency_str : '<em>'.__('There are no emergency codes left. You will need to reset your private key.', 'two-factor-authentication').'</em>';
		
		return $emergency_str;
	}
	
	/**
	 * Check a code for a user (checks the code only - does not check activation status etc.)
	 *
	 * @param Integer $user_id	 			- WP user ID
	 * @param String  $user_code 			- the code to check
	 * @param Boolean $allow_emergency_code - whether to check against emergency codes
	 *
	 * @return Boolean
	 */
	public function check_code_for_user($user_id, $user_code, $allow_emergency_code = true) {
		
		$tfa_priv_key = get_user_meta($user_id, 'tfa_priv_key_64', true);
		// 		$tfa_last_login = get_user_meta($user_id, 'tfa_last_login', true); // Unused
		$tfa_last_pws_arr = get_user_meta($user_id, 'tfa_last_pws', true);
		$tfa_last_pws = @$tfa_last_pws_arr ? $tfa_last_pws_arr : array();
		$alg = $this->get_user_otp_algorithm($user_id);
		
		$current_time_window = intval(time()/30);
		
		//Give the user 1,5 minutes time span to enter/retrieve the code
		//Or check $this->check_forward_counter_window number of events if hotp
		$codes = $this->generate_otps_for_login_check($user_id, $tfa_priv_key);
		
		//A recently used code was entered; that's not OK.
		if (in_array($this->hash($user_code, $user_id), $tfa_last_pws)) return false;
		
		$match = false;
		foreach ($codes as $index => $code) {
			if (trim($code->toHotp(6)) == trim($user_code)) {
				$match = true;
				$found_index = $index;
				break;
			}
		}
		
		// Check emergency codes
		if (!$match) {
			$emergency_codes = $allow_emergency_code ? get_user_meta($user_id, 'simba_tfa_emergency_codes_64', true) : array();
			
			if (!$emergency_codes) return $match;
			
			$dec = array();
			foreach ($emergency_codes as $emergency_code)
				$dec[] = trim($this->decryptString(trim($emergency_code), $user_id));
			
			$in_array = array_search($user_code, $dec);
			$match = $in_array !== false;
			
			//Remove emergency code
			if ($match) {
				array_splice($emergency_codes, $in_array, 1);
				update_user_meta($user_id, 'simba_tfa_emergency_codes_64', $emergency_codes);
				do_action('simba_tfa_emergency_code_used', $user_id, $emergency_codes);
			}
			
		} else {
			//Add the used code as well so it cant be used again
			//Keep the two last codes
			$tfa_last_pws[] = $this->hash($user_code, $user_id);
			$nr_of_old_to_save = $alg == 'hotp' ? $this->check_forward_counter_window : $this->check_back_time_windows;
			
			if (count($tfa_last_pws) > $nr_of_old_to_save) array_splice($tfa_last_pws, 0, 1);
			
			update_user_meta($user_id, 'tfa_last_pws', $tfa_last_pws);
		}
		
		if ($match) {
			//Save the time window when the last successful login took place
			update_user_meta($user_id, 'tfa_last_login', $current_time_window);
			
			//Update the counter if HOTP was used
			if ($alg == 'hotp') {
				$counter = $this->getUserCounter($user_id);
				
				$enc_new_counter = $this->encryptString($counter+1, $user_id);
				update_user_meta($user_id, 'tfa_hotp_counter', $enc_new_counter);
				
				if ($found_index > 10) update_user_meta($user_id, 'tfa_hotp_off_sync', 1);
			}
		}
		
		return $match;
		
	}
	
	public function getUserCounter($user_ID) {
		$enc_counter = get_user_meta($user_ID, 'tfa_hotp_counter', true);
		return $enc_counter ? trim($this->decryptString(trim($enc_counter), $user_ID)) : '';
	}
	
	public function changeUserAlgorithmTo($user_id, $new_algorithm) {
		update_user_meta($user_id, 'tfa_algorithm_type', $new_algorithm);
		delete_user_meta($user_id, 'tfa_hotp_off_sync');
		
		$counter_start = rand(13, 999999999);
		$enc_counter_start = $this->encryptString($counter_start, $user_id);
		
		if ('hotp' == $new_algorithm) {
			update_user_meta($user_id, 'tfa_hotp_counter', $enc_counter_start);
		} else {
			delete_user_meta($user_id, 'tfa_hotp_counter');
		}
	}
	
	/**
	 * Whether HOTP or TOTP is being used
	 *
	 * @param Integer $user_id - WordPress user ID
	 *
	 * @return String - 'hotp' or 'totp'
	 */
	public function get_user_otp_algorithm($user_id) {
		global $simba_two_factor_authentication;
		$setting = get_user_meta($user_id, 'tfa_algorithm_type', true);
		$default_hmac = $simba_two_factor_authentication->get_option('tfa_default_hmac');
		$default_hmac = $default_hmac ? $default_hmac : $this->default_hmac;
		
		$setting = $setting === false || !$setting ? $default_hmac : $setting;
		return $setting;
	}
	
	private function get_iv_size() {
		// mcrypt first, for backwards compatibility
		if (function_exists('mcrypt_get_iv_size')) {
			return $GLOBALS['simba_two_factor_authentication']->is_mcrypt_deprecated() ? @mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC) : mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		} elseif (function_exists('openssl_cipher_iv_length')) {
			return openssl_cipher_iv_length('AES-128-CBC');
		}
		throw new Exception('One of the mcrypt or openssl PHP modules needs to be installed');
	}
	
	private function encrypt($key, $string, $iv) {
		// Prefer OpenSSL, because it uses correct padding, and its output can be decrypted by mcrypt - whereas, the converse is not true
		if (function_exists('openssl_encrypt')) {
			return openssl_encrypt($string, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
		} elseif (function_exists('mcrypt_encrypt')) {
			return $GLOBALS['simba_two_factor_authentication']->is_mcrypt_deprecated() ? @mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $string, MCRYPT_MODE_CBC, $iv) : mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $string, MCRYPT_MODE_CBC, $iv);
		}
		throw new Exception('One of the mcrypt or openssl PHP modules needs to be installed');
	}
	
	private function decrypt($key, $enc, $iv, $force_openssl = false) {
		// Prefer mcrypt, because it can decrypt the output of both mcrypt_encrypt() and openssl_decrypt(), whereas (because of mcrypt_encrypt() using bad padding), the converse is not true
		if (function_exists('mcrypt_decrypt') && !$force_openssl) {
			return $GLOBALS['simba_two_factor_authentication']->is_mcrypt_deprecated() ? @mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $enc, MCRYPT_MODE_CBC, $iv) : mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $enc, MCRYPT_MODE_CBC, $iv);
		} elseif (function_exists('openssl_decrypt')) {
			$decrypted = openssl_decrypt($enc, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
			if (false === $decrypted && !$force_openssl) {
				$extra = function_exists('wp_debug_backtrace_summary') ? " backtrace: ".wp_debug_backtrace_summary() : '';
				error_log("TFA decryption failure: was your site migrated to a server without mcrypt? You may need to install mcrypt, or disable TFA, in order to successfully decrypt data that was previously encrypted with mcrypt.$extra");
			}
			return $decrypted;
		}
		if ($force_openssl) return false;
		throw new Exception('One of the mcrypt or openssl PHP modules needs to be installed');
	}
	
	public function encryptString($string, $salt_suffix) {
		$key = $this->hashAndBin($this->pw_prefix.$salt_suffix, $this->salt_prefix.$salt_suffix);
		
		$iv_size = $this->get_iv_size();
		$iv = $GLOBALS['simba_two_factor_authentication']->random_bytes($iv_size);
		
		$enc = $this->encrypt($key, $string, $iv);
		
		if (false === $enc) return false;
		
		$enc = $iv.$enc;
		$enc_b64 = base64_encode($enc);
		return $enc_b64;
	}
	
	private function decryptString($enc_b64, $salt_suffix, $force_openssl = false) {
		$key = $this->hashAndBin($this->pw_prefix.$salt_suffix, $this->salt_prefix.$salt_suffix);
		
		$iv_size = $this->get_iv_size();
		$enc_conc = bin2hex(base64_decode($enc_b64));
		
		$iv = hex2bin(substr($enc_conc, 0, $iv_size*2));
		$enc = hex2bin(substr($enc_conc, $iv_size*2));
		
		$string = $this->decrypt($key, $enc, $iv, $force_openssl);
		
		// Remove padding bytes
		return rtrim($string, "\x00..\x1F");
	}
	
	private function hashAndBin($pw, $salt) {
		$key = $this->hash($pw, $salt);
		$key = pack('H*', $key);
		// Yes: it's a null encryption key. See: https://wordpress.org/support/topic/warning-mcrypt_decrypt-key-of-size-0-not-supported-by-this-algorithm-only-k?replies=5#post-6806922
		// Basically: the original plugin had a bug here, which caused a null encryption key. This fails on PHP 5.6+. But, fixing it would break backwards compatibility for existing installs - and note that the only unknown once you have access to the encrypted data is the AUTH_SALT and AUTH_KEY constants... which means that actually the intended encryption was non-portable, + problematic if you lose your wp-config.php or try to migrate data to another site, or changes these values. (Normally changing these values only causes a compulsory re-log-in - but with the intended encryption in the original author's plugin, it'd actually cause a permanent lock-out until you disabled his plugin). If someone has read-access to the database, then it'd be reasonable to assume they have read-access to wp-config.php too: or at least, the number of attackers who can do one and not the other would be small. The "encryption's" not worth it.
		// In summary: this isn't encryption, and is not intended to be.
		return str_repeat(chr(0), 16);
	}
	
	private function hash($pw, $salt) {
		//$hash = hash_pbkdf2('sha256', $pw, $salt, 10);
		//$hash = crypt($pw, '$5$'.$salt.'$');
		$hash = md5($salt.$pw);
		return $hash;
	}
	
	private function randString($len = 10) {
		$chars = '23456789QWERTYUPASDFGHJKLZXCVBNM';
		$chars = str_split($chars);
		shuffle($chars);
		if (function_exists('random_int')) {
			$code = '';
			for ($i = 1; $i <= $len; $i++) {
				$code .= $chars[random_int(0, count($chars)-1)];
			}
		} else {
			$code = implode('', array_splice($chars, 0, $len));
		}
		return $code;
	}
	
	public function setUserHMACTypes() {
		// We need this because we dont want to change third party apps users algorithm
		$users = get_users(array('meta_key' => 'simbatfa_delivery_type', 'meta_value' => 'third-party-apps'));
		if (empty($users)) return;
		foreach ($users as $user) {
			$tfa_algorithm_type = get_user_meta($user->ID, 'tfa_algorithm_type', true);
			if ($tfa_algorithm_type) continue;
			
			update_user_meta($user->ID, 'tfa_algorithm_type', $this->get_user_otp_algorithm($user->ID));
		}
	}

}

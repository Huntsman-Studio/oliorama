<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
/**
 * Class WC_Vivawallet_Credentials
 *
 * @class   WC_Vivawallet_Credentials
 */
class WC_Vivawallet_Credentials {

	/**
	 * Viva settings
	 *
	 * @var array
	 */
	public static $viva_settings;

	/**
	 * Test mode
	 *
	 * @var string
	 */
	public static $test_mode;


	/**
	 * Construct.
	 */
	public function __construct() {

		self::$viva_settings = get_option( 'woocommerce_vivawallet_native_settings', array() );

	}

	/**
	 * Get_client_data.
	 *
	 * @param bool $force force reload data.
	 *
	 * @return array
	 */
	public static function get_client_data( $force = false ) {

		if ( $force || empty( self::$viva_settings ) ) {
			// update settings from DB.
			self::$viva_settings = get_option( 'woocommerce_vivawallet_native_settings', array() );
		}

		$client_id     = isset( self::$viva_settings['client_id'] ) ? self::$viva_settings['client_id'] : '';
		$client_secret = isset( self::$viva_settings['client_secret'] ) ? self::$viva_settings['client_secret'] : '';
		$source_code   = isset( self::$viva_settings['source_code'] ) ? self::$viva_settings['source_code'] : '';

		$demo_client_id     = isset( self::$viva_settings['test_client_id'] ) ? self::$viva_settings['test_client_id'] : '';
		$demo_client_secret = isset( self::$viva_settings['test_client_secret'] ) ? self::$viva_settings['test_client_secret'] : '';
		$demo_source_code   = isset( self::$viva_settings['test_source_code'] ) ? self::$viva_settings['test_source_code'] : '';

		$test_mode = isset( self::$viva_settings['test_mode'] ) ? self::$viva_settings['test_mode'] : 'no';

		$client_id     = ( 'yes' === $test_mode ) ? $demo_client_id : $client_id;
		$client_secret = ( 'yes' === $test_mode ) ? $demo_client_secret : $client_secret;
		$source_code   = ( 'yes' === $test_mode ) ? $demo_source_code : $source_code;

		return array(
			'test_mode'     => $test_mode,
			'client_id'     => $client_id,
			'client_secret' => $client_secret,
			'source_code'   => $source_code,
		);
	}
	/**
	 * Get_credentials.
	 *
	 * @param bool $force force reload credentials.
	 *
	 * @return array|mixed
	 */
	public static function get_credentials( $force = false ) {

		$time             = time();
		$timeout_duration = 600; // 10 min.

		if ( null === WC()->session ) {
			WC()->session = new WC_Session_Handler();
			WC()->session->init();
		}

		if ( ! $force ) { // if force is false check the timestamp.
			if ( null === WC()->session->get( 'VW_LAST_ACTIVITY' ) ) { // if session var is not set force is true.
				$force = true;
			} elseif ( ( $time - WC()->session->get( 'VW_LAST_ACTIVITY' ) ) > $timeout_duration ) {
				$force = true; // force to reload if time exceeded.
			}
		}

		if ( $force ) {
			// update settings from DB.
			self::$viva_settings = get_option( 'woocommerce_vivawallet_native_settings', array() );
		}

		if ( empty( WC()->session->get( 'VW_CREDENTIALS' ) ) || $force ) {

			$test_mode = isset( self::$viva_settings['test_mode'] ) ? self::$viva_settings['test_mode'] : '';

			$client_id     = isset( self::$viva_settings['client_id'] ) ? self::$viva_settings['client_id'] : '';
			$client_secret = isset( self::$viva_settings['client_secret'] ) ? self::$viva_settings['client_secret'] : '';

			$demo_client_id     = isset( self::$viva_settings['test_client_id'] ) ? self::$viva_settings['test_client_id'] : '';
			$demo_client_secret = isset( self::$viva_settings['test_client_secret'] ) ? self::$viva_settings['test_client_secret'] : '';

			$client_for_front      = ( 'yes' === $test_mode ) ? $demo_client_id : $client_id;
			$source_code_for_front = ( 'yes' === $test_mode ) ? $demo_client_secret : $client_secret;

			$res = array(
				'demo_token_back' => WC_Vivawallet_Helper::get_token( $demo_client_id, $demo_client_secret, 'yes', 'back' ),
				'live_token_back' => WC_Vivawallet_Helper::get_token( $client_id, $client_secret, 'no', 'back' ),
				'token_front'     => WC_Vivawallet_Helper::get_token( $client_for_front, $source_code_for_front, $test_mode, 'front' ),
			);

			WC()->session->set( 'VW_CREDENTIALS', $res );
			WC()->session->set( 'VW_LAST_ACTIVITY', $time );

		} else {
			$res = WC()->session->get( 'VW_CREDENTIALS' );
		}

		return $res;
	}
}

new WC_Vivawallet_Credentials();

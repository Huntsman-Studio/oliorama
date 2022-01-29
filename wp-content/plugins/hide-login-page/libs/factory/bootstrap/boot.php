<?php
/**
 * Factory Bootstrap
 *
 * @author        Alex Kovalev <alex.kovalevv@gmail.com>
 * @since         1.0.0
 * @package       factory-bootstrap
 * @copyright (c) 2018, Webcraftic Ltd
 *
 */

// Exit if accessed directly
if( !defined('ABSPATH') ) {
	exit;
}

// module provides function only for the admin area
if( !is_admin() ) {
	return;
}

if( defined('FACTORY_BOOTSTRAP_446_LOADED') ) {
	return;
}

define('FACTORY_BOOTSTRAP_446_VERSION', '4.4.6');
define('FACTORY_BOOTSTRAP_446_LOADED', true);

if( !defined('FACTORY_FLAT_ADMIN') ) {
	define('FACTORY_FLAT_ADMIN', true);
}

define('FACTORY_BOOTSTRAP_446_DIR', dirname(__FILE__));
define('FACTORY_BOOTSTRAP_446_URL', plugins_url(null, __FILE__));

require_once(FACTORY_BOOTSTRAP_446_DIR . '/includes/functions.php');

/**
 * @param Wbcr_Factory446_Plugin $plugin
 */
add_action('wbcr_factory_bootstrap_446_plugin_created', function ($plugin) {
	$manager = new Wbcr_FactoryBootstrap446_Manager($plugin);
	$plugin->setBootstap($manager);
});



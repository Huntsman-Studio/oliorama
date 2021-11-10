<?php

// Set image data
include 'inc/set-image-data.php';		
// Theme support
include 'inc/theme_support.php';

if ( ! defined( 'OLIORAMA_DIR_PATH' ) ) {
	define( 'OLIORAMA_DIR_PATH', untrailingslashit( get_template_directory() ) );
}

if ( ! defined( 'OLIORAMA_DIR_URI' ) ) {
	define( 'OLIORAMA_DIR_URI', untrailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'OLIORAMA_BUILD_URI' ) ) {
	define( 'OLIORAMA_BUILD_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build' );
}

if ( ! defined( 'OLIORAMA_BUILD_PATH' ) ) {
	define( 'OLIORAMA_BUILD_PATH', untrailingslashit( get_template_directory() ) . '/assets/build' );
}

if ( ! defined( 'OLIORAMA_BUILD_JS_URI' ) ) {
	define( 'OLIORAMA_BUILD_JS_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build/js' );
}

if ( ! defined( 'OLIORAMA_BUILD_JS_DIR_PATH' ) ) {
	define( 'OLIORAMA_BUILD_JS_DIR_PATH', untrailingslashit( get_template_directory() ) . '/assets/build/js' );
}

if ( ! defined( 'OLIORAMA_BUILD_IMG_URI' ) ) {
	define( 'OLIORAMA_BUILD_IMG_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build/src/img' );
}

if ( ! defined( 'OLIORAMA_BUILD_CSS_URI' ) ) {
	define( 'OLIORAMA_BUILD_CSS_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build/css' );
}

if ( ! defined( 'OLIORAMA_BUILD_CSS_DIR_PATH' ) ) {
	define( 'OLIORAMA_BUILD_CSS_DIR_PATH', untrailingslashit( get_template_directory() ) . '/assets/build/css' );
}

if ( ! defined( 'OLIORAMA_BUILD_LIB_URI' ) ) {
	define( 'OLIORAMA_BUILD_LIB_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build/library' );
}

// Register styles
function oliorama_register_styles() {
	wp_register_style( 'main-css', OLIORAMA_BUILD_CSS_URI . '/main.css', [], filemtime( OLIORAMA_BUILD_CSS_DIR_PATH . '/main.css' ), 'all' );
	wp_enqueue_style( 'main-css' );
}
add_action( 'wp_enqueue_scripts', 'oliorama_register_styles' );

// Register scripts
function oliorama_register_scripts() {
	wp_register_script('main-js', OLIORAMA_BUILD_JS_URI . '/main.js', 'jquery', [], true);
	wp_enqueue_script('main-js');
}
add_action( 'wp_enqueue_scripts', 'oliorama_register_scripts' );
?>
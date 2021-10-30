<?php
    // This script adds woo to theme support
    function oliorama_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }

    add_action( 'after_setup_theme', 'oliorama_add_woocommerce_support' );
?>
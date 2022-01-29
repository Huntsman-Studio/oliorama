<?php

    // Disable guttenberg
    add_filter( 'use_block_editor_for_post', '__return_false' );

    add_theme_support('menus');             # Menus
    add_theme_support('post-thumbnails');   # Thumbnails on posts

    // Woo Support
    function mytheme_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }

    add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
    // Woo Support

    // Add widget 
    register_sidebar(
        
        array(
            'name' => 'Page Sidebar',
            'id' => 'page-sidebar',
            'before_title' => '<h4>',
            'after_title' => '</h4>'
        )
    );
?>
<?php

    // This script register fonts on WP
    function register_fonts() {
        if( !is_admin() ) {
            wp_register_styles('@ FONT NAME @','@ FONT LINK @');
            
            wp_enqueue_styles('@ FONT NAME @');
        }
    }

    // Action to function
    add_action('wp_enqueue_scripts', 'register_fonts');
?>
<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class Wt_Advanced_Order_Number_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        //wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wt-advanced-order-number-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        //wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wt-advanced-order-number-admin.js', array('jquery'), $this->version, false);
        if(isset($_GET['page']) && $_GET['page']=='wc-settings' && isset($_GET['tab']) && $_GET['tab']=='wts_settings')
        {
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'views/wt-settings-screen.js', array('jquery'), $this->version);
            $params=array(
                'msgs'=>array(
                    'prev'=>__('Preview : ','wt-woocommerce-sequential-order-numbers'),
                )
            );
            wp_localize_script($this->plugin_name, 'wt_seq_settings', $params);
        }
    }

    public function add_settings_page_popup() {
        if(isset($_GET['page']) && $_GET['page']=='wc-settings' && isset($_GET['tab']) && $_GET['tab']=='wts_settings')
        {
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/views/wt-advanced-order-number-admin-settings-page.php';
        }
    }

    public function add_plugin_links_wt_wtsequentialordnum($links) {


        $plugin_links = array(
            '<a href="' . admin_url('admin.php?page=wc-settings&tab=wts_settings') . '">' . __('Settings', 'wt-woocommerce-sequential-order-numbers') . '</a>',
            '<a target="_blank" href="https://wordpress.org/support/plugin/wt-woocommerce-sequential-order-numbers/">' . __('Support', 'wt-woocommerce-sequential-order-numbers') . '</a>',
            '<a target="_blank" href="https://wordpress.org/support/plugin/wt-woocommerce-sequential-order-numbers/reviews/?rate=5#new-post">' . __('Review', 'wt-woocommerce-sequential-order-numbers') . '</a>',
        );
        if (array_key_exists('deactivate', $links)) {
            $links['deactivate'] = str_replace('<a', '<a class="wtsequentialordnum-deactivate-link"', $links['deactivate']);
        }
        return array_merge($plugin_links, $links);
    }

    public function custom_ordernumber_search_field($search_fields) {

        array_push($search_fields, '_order_number');
        return $search_fields;
    }

}
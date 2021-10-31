<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class Wt_Advanced_Order_Number {

    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        if (defined('WT_SEQUENCIAL_ORDNUMBER_VERSION')) {
            $this->version = WT_SEQUENCIAL_ORDNUMBER_VERSION;
        } else {
            $this->version = '1.4.0';
        }
        $this->plugin_name = 'wt-advanced-order-number';
        $this->plugin_base_name = WT_SEQUENCIAL_ORDNUMBER_BASE_NAME;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        if ( is_admin() ) {
            add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_woocommerce_settings_tab'));
        }
    }

    private function load_dependencies() {

        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wt-advanced-order-number-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wt-advanced-order-number-i18n.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wt-advanced-order-number-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wt-advanced-order-number-public.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wt-advanced-order-number-review_request.php';

        $this->loader = new Wt_Advanced_Order_Number_Loader();
    }

    private function set_locale() {

        $plugin_i18n = new Wt_Advanced_Order_Number_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    private function define_admin_hooks() {

        $plugin_admin = new Wt_Advanced_Order_Number_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_filter('plugin_action_links_' . $this->get_plugin_base_name(), $plugin_admin, 'add_plugin_links_wt_wtsequentialordnum');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_footer', $plugin_admin, 'add_settings_page_popup');
        if ( 'yes' === get_option( 'wt_custom_order_number_search', 'yes' ) ) {
            $this->loader->add_filter('woocommerce_shop_order_search_fields', $plugin_admin, 'custom_ordernumber_search_field');
        }

        add_action('plugins_loaded', array($this, 'setup_sequential_number'));
    
    }

    public function add_woocommerce_settings_tab( $settings ) {
            $settings[] = include plugin_dir_path( __FILE__ ) .'class-wt-advanced-order-number-settings.php';
            return $settings;
    }

    public static function save_settings() {

        $wt_sequence_prefix = sanitize_text_field(get_option('wt_sequence_order_number_prefix'));
        $wt_sequence_start = (int) get_option('wt_sequence_order_number_start', 1);
        $wt_renumerate = get_option('wt_renumerate','no');
        if(isset($wt_sequence_prefix) || isset($wt_sequence_start) || isset($wt_renumerate))
        {
            update_option('wt_sequence_order_number_prefix',$wt_sequence_prefix);
            update_option('wt_sequence_order_number_start', $wt_sequence_start);
            update_option('wt_renumerate', $wt_renumerate,'no');
            $new_start_num=get_option('wt_sequence_order_number_start');
            $last_start_num=get_option('wt_last_sequence_start');
            $wt_renumerate = get_option('wt_renumerate','no');
            if( $wt_renumerate === 'yes' || $new_start_num !== $last_start_num)
            {
                 self::initial_setup(TRUE);
            }
           
        }
    }

    public function setup_sequential_number() {

        //add_action('wp_insert_post', array($this, 'set_sequential_number'), 10, 2);
        //add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'set_sequential_number' ), 10, 1 );
        add_action( 'woocommerce_new_order', array( $this, 'set_sequential_number' ), 10, 1 );
        add_action( 'woocommerce_process_shop_order_meta',    array( $this, 'set_sequential_number' ), 35, 2 );
        add_action( 'woocommerce_before_resend_order_emails', array( $this, 'set_sequential_number' ), 10, 2 );

        //REST API
        add_action( 'woocommerce_api_create_order', array( $this, 'set_sequential_number' ), 10, 1 );

        // Show sequential order number
        add_filter('woocommerce_order_number', array($this, 'display_sequence_number'), 10, 2);

        // WC Subscriptions support
        add_filter( 'wcs_subscription_meta', array( $this, 'subscriptions_remove_renewal_order_number_meta' ) );
        add_filter( 'wcs_renewal_order_meta_query', array( $this, 'subscriptions_remove_renewal_order_number_meta' ) );
        add_filter( 'wcs_renewal_order_created',    array( $this, 'subscriptions_sequential_order_number' ), 10, 2 );

        // Webtoffee Subscriptions support
        add_filter( 'hf_subscription_meta_query', array( $this, 'subscriptions_remove_renewal_order_number_meta' ) );
        add_filter( 'hf_renewal_order_meta_query', array( $this, 'subscriptions_remove_renewal_order_number_meta' ) );
        add_filter( 'hf_renewal_order_created',    array( $this, 'subscriptions_sequential_order_number' ), 10, 2 );

        // [woocommerce_order_tracking] shortcode support
        if ( get_option( 'wt_custom_order_number_tracking_enabled', 'yes' ) === 'yes' ) {
            add_action( 'init', array( $this, 'remove_order_id_tracking_filter' ) );
            add_filter( 'woocommerce_shortcode_order_tracking_order_id', array( $this,'woocommerce_shortcode_order_tracking_order_id'), 10, 1 );
        }
        if (is_admin() && (!defined('DOING_AJAX'))) {
           // self::initial_setup();
        }
    }

    public static function get_sequence_prefix($order_id) {

        $prefix = sanitize_text_field(get_option('wt_sequence_order_number_prefix', ''));
        $prefix = apply_filters('wt_order_number_sequence_prefix', $prefix,$order_id);
        return $prefix;
    }

    public static function initial_setup($rerun = FALSE) {


        $wt_advanced_order_number_version = get_option('wt_advanced_order_number_version');

        $wt_renumerate = get_option('wt_renumerate','no');

        if ( ( !$wt_advanced_order_number_version || $rerun === TRUE ) && $wt_renumerate === 'yes') {

            $offset = (int) get_option('wt_advanced_order_number_offset', 0);

            $start = (int) get_option('wt_sequence_order_number_start', 1);

            $posts_per_page = 50;

            do {
                $order_ids = get_posts(array('post_type' => 'shop_order', 'fields' => 'ids', 'offset' => $offset, 'posts_per_page' => $posts_per_page, 'post_status' => 'any', 'orderby' => 'date', 'order' => 'ASC'));


                if (!empty($order_ids)) {

                    foreach ($order_ids as $order_id) {
                        if (get_post_meta($order_id, '_order_number', TRUE) === '' || $rerun === TRUE) {
                            $prefix = self::get_sequence_prefix($order_id);
                            $start_no_padding=self::add_order_no_padding($start);
                            $order_number = self::add_prefix_suffix($start_no_padding,$order_id);
                            $order_number = apply_filters('wt_order_number_sequence_data', $order_number, $prefix, $order_id);
                            update_post_meta($order_id, '_order_number', $order_number);
                            $start++;
                        }
                    }
                }


                $offset += $posts_per_page;
            } while (count($order_ids) === $posts_per_page);


            update_option('wt_advanced_order_number_version', WT_SEQUENCIAL_ORDNUMBER_VERSION);
            update_option('wt_last_order_number', $start - 1);
        } else {
            update_option('wt_advanced_order_number_version', WT_SEQUENCIAL_ORDNUMBER_VERSION);
            $start=get_option('wt_sequence_order_number_start', 1);
            update_option('wt_last_order_number',$start-1);
        }
        update_option('wt_last_sequence_start', get_option('wt_sequence_order_number_start', 1));
    }

    /**
     * Sets an order number on a subscriptions-created order.
     *
     * @since 1.2.5
     *
     * @param $renewal_order the new renewal order object
     * @param $subscription Post ID of a 'shop_subscription' post, or instance of a WC_Subscription object or HF_Woocommerce_Subscription
     * @return \WC_Order renewal order instance
     */

    public function subscriptions_sequential_order_number( $renewal_order, $subscription ) {

        if ( $renewal_order instanceof WC_Order ) {

            $order_post = get_post( $renewal_order->get_id() );

            $this->set_sequential_number( $order_post->ID, $order_post );
        }

        return $renewal_order;
    }

    /**
     * Don't copy over order number meta when creating a parent or child renewal order
     *
     * Prevents unnecessary order meta from polluting parent renewal orders,
     * and set order number for subscription orders
     *
     * @since 1.2.5
     * @param array $order_meta_query query for pulling the metadata
     * @return string
     */

    public function subscriptions_remove_renewal_order_number_meta( $order_meta_query ) {
        return $order_meta_query . " AND meta_key NOT IN ( '_order_number' )";
    }

    /**
     * Remove the WooCommerce filter which convers the order numbers to integers by removing the * * characters or prefix.
     * @since   1.2.6
     */
    public function remove_order_id_tracking_filter() {
        remove_filter( 'woocommerce_shortcode_order_tracking_order_id', 'wc_sanitize_order_id' );
    }

    /**
     * Add woocommerce_order_number_to_tracking compatibility.
     *
     * @param string $order_id.
     * @since   1.2.6
     * @return $order_number instead of $order_id
     */
    public function woocommerce_shortcode_order_tracking_order_id( $order_id ) {
        $args    = array(
            'post_type'      => 'shop_order',
            'post_status'    => 'any',
            'meta_query'     => array(
                array(
                    'key'        => '_order_number',
                    'value'      => $order_id,
                    'compare'    => '=',
                )
            )
        );
        $query   = new WP_Query( $args );
        if ( !empty( $query->posts ) ) {
            $order_id = $query->posts[ 0 ]->ID;
        }
        return $order_id;
    }

    /**
    *   @since 1.3.3
    *   Adding padding number to sequential number
    *   @return $order_number with padding
    */
    public static function add_order_no_padding($order_number) 
    {
        $padding = '';
        $padding_no=get_option('wt_sequence_order_number_padding',0);
        $padding_count =(int) $padding_no - strlen($order_number);
        if ($padding_count > 0) 
        {
            for ($i = 0; $i < $padding_count; $i++)
            {
                $padding .= '0';
            }
        }
        return $padding.$order_number;
    }

     /**
    *   @since 1.3.6
    *   Replace date shortcode from sequential number prefix/suffix data
    *   @return string
    */
    public static function get_date_from_shortcode($shortcode_text, $order_id) 
    {   
        preg_match_all("/\[([^\]]*)\]/", $shortcode_text, $matches);
        if(!empty($matches[1]))
        { 
            foreach($matches[1] as $date_shortcode) 
            { 
                $match=array();
                $date_val=time();
                $order_date_format=$date_shortcode;
                $order_date_format=apply_filters('wt_order_number_date_format',$order_date_format);
                if(!empty($order_id))
                { 
                    $date_val=strtotime(get_the_date('Y-m-d H:i:s', $order_id));
                }
                $date=date($order_date_format, $date_val);
                $shortcode_text=str_replace("[$date_shortcode]", $date, $shortcode_text); 
            }
        }
        return $shortcode_text;
    }

    /** 
    *   @since 1.3.6
    *   Add Prefix/Suffix to sequential number
    *   @return string
    */
    public static function add_prefix_suffix($padded_order_number,$order_id) 
    {          
        $order_template = get_option('wt_sequence_order_number_format');
        $prefix = self::get_sequence_prefix($order_id);
        $date_prefix = sanitize_text_field(get_option('wt_sequence_order_date_prefix'));
        $suffix='';
        $date_suffix='';
        if($order_template=="")
        {
            if($prefix!='' && $date_prefix!='')
            {
                $order_template='[prefix][date][number]';
            }
            elseif($prefix!='')
            {
                $order_template = '[prefix][number]'; 
            }
            elseif($date_prefix!= '')
            {
                $order_template = '[date][number]'; 
            }
            elseif($date_prefix == '' && $prefix == '' )
            {
                $order_template = '[number]'; 
            }
        }
        if($date_prefix != '')
        {
            $date_prefix=self::get_date_from_shortcode($date_prefix, $order_id);
        }
       
        return str_replace(array('[prefix]','[date]','[number]','[suffix]','[date_suffix]'),array($prefix,$date_prefix,$padded_order_number,$suffix,$date_suffix),$order_template); 
    }

    private function define_public_hooks() {

        $plugin_public = new Wt_Advanced_Order_Number_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

    public function set_sequential_number($post_id, $post = array() ) {

        global $wpdb;

        if ( is_array( $post ) || is_null( $post ) || ( $post->post_type === 'shop_order' && $post->post_status == 'auto-draft' ) ) {
            $order = wc_get_order( $post_id );
            $order_id = (WC()->version < '2.7.0') ? $order->id : $order->get_id();
            $order_number = get_post_meta($order_id, '_order_number', TRUE);
            if (empty($order_number)) {

                $prefix = self::get_sequence_prefix($order_id);

                $nextnumber = 1;

                $last_order_num = get_option('wt_last_order_number');
                
                if (!$last_order_num) {

                    $query = "SELECT '_order_number', IF( MAX( CAST( meta_value as UNSIGNED ) ) IS NULL, 1, MAX( CAST( meta_value as UNSIGNED ) ) + 1 ) as NEXTNUM FROM {$wpdb->postmeta} WHERE meta_key='_order_number'";
                    $res = $wpdb->get_results($query);
                    $nextnumber = $res[0]->NEXTNUM;
                    $nextnumber = $nextnumber - 1;
                }


                $wt_last_order_number = get_option('wt_last_order_number', $nextnumber);

                $next_insert_id = $wt_last_order_number + 1;

                $next_insert_id_padding=self::add_order_no_padding($next_insert_id);

                $next_order_number = self::add_prefix_suffix($next_insert_id_padding,$order_id);

                $sql = "INSERT INTO {$wpdb->postmeta} (post_id, meta_key, meta_value) VALUES (%d,%s,%s)";

                $query = $wpdb->prepare($sql, $post_id, '_order_number', $next_order_number);

                $res = $wpdb->query($query);

                update_option('wt_last_order_number', $next_insert_id,'no');
            }
        }
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_plugin_base_name() {
        return $this->plugin_base_name;
    }

    public function get_loader() {
        return $this->loader;
    }

    public function get_version() {
        return $this->version;
    }

    public function display_sequence_number($order_number, $order) {

        $order_id = (WC()->version < '2.7.0') ? $order->id : $order->get_id();
        $sequential_order_number = get_post_meta($order_id, '_order_number', TRUE);
        $sequential_order_number = apply_filters('wt_alter_sequence_number',$sequential_order_number,$order_id);
        return ($sequential_order_number) ? $sequential_order_number : $order_number;
    }

    public function run() {
        $this->loader->run();
    }

}

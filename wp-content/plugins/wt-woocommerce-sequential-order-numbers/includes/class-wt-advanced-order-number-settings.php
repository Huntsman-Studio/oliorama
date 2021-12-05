<?php

/**
 *	WooCommerce settings page
 *
 *	This code creates a full WooCommerce settings page by extending the WC_Settings_Page class.
 *	By extending the WC_Settings_Page class, we can control every part of the settings page.
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Wt_Advanced_Order_Number_Settings_Page' ) ) :

class Wt_Advanced_Order_Number_Settings_Page extends WC_Settings_Page {
	
	public function __construct() {

		$this->id = 'wts_settings';
		$this->label = __('Sequential Order Number', 'wt-woocommerce-sequential-order-numbers' );

		/**
		 *	Define all hooks instead of inheriting from parent
		 */

		// parent::__construct();

		// Add the tab to the tabs array
		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );

		// Add new section to the page
		add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );

		// Add settings
		add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );

		// Process/save the settings
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
	}

	/**
	 *	Get sections
	 *
	 *	@return array
	 */
	public function get_sections() {

		// Must contain more than one section to display the links
		// Make first element's key empty ('')
		$sections = array(
			'' => __( 'Settings', 'wt-woocommerce-sequential-order-numbers' ),
			'free_vs_pro' => __( 'Free vs. Pro', 'wt-woocommerce-sequential-order-numbers' )
		);

		return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
	}

	/**
	 *	Output sections
	 */
	public function output_sections() {

		global $current_section;

		$sections = $this->get_sections();

		if ( empty( $sections ) || 1 === sizeof( $sections ) ) {
			return;
		}

		echo '<ul class="subsubsub">';

		$array_keys = array_keys( $sections );

		foreach ( $sections as $id => $label ) {
			echo '<li><a href="' . esc_url(admin_url( 'admin.php?page=wc-settings&tab=' . $this->id . '&section=' . sanitize_title( $id ) ) ). '" class="' . esc_attr(( $current_section == $id ? 'current' : '' )) . '">' . esc_html($label) . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';
		}

		echo '</ul><br class="clear" />';
	}

	/**
	 *	Get settings array
	 *
	 *	@return array
	 */
	public function get_settings() {

		global $current_section;

		$settings = array();

		
		if ( $current_section == 'free_vs_pro' ) 
		{
			$settings = array();
		}
		else
		{

			$settings = array(

				array(
					'name' =>__('Settings','wt-woocommerce-sequential-order-numbers'),
					'type' => 'title',
					'desc' =>  __( 'Set custom sequential order numbers for WooCommerce orders.', 'wt-woocommerce-sequential-order-numbers' ),
					'id' => 'wt_sequencial_settings_page',
				),
				array(
					'name' =>__(' ','wt-woocommerce-sequential-order-numbers'),
					'type' => 'title',
					'desc' =>  __(sprintf(
								'<a href="%s" target="_blank">%s</a>',
								'https://www.webtoffee.com/sequential-order-number-woocommerce-plugin-user-guide/',
								'Read documentation'
							),'wt-woocommerce-sequential-order-numbers'),
					'id' => 'wt_sequencial_documentation',
				),
				array(
					'title' => __( 'Order number format', 'wt-woocommerce-sequential-order-numbers' ),
					'type' => 'select',
					'desc' => __( 'Select an order number format with number, prefix, or date.','wt-woocommerce-sequential-order-numbers'),
					'desc_tip' => true,
					'id'	=> 'wt_sequence_order_number_format',
					'default'  => '',
					'css' => 'min-width:300px;',
					'options'  => array(
						'[number]'   => __( '[Number]', 'wt-woocommerce-sequential-order-numbers' ),
						'[prefix][number]'=> __( '[Prefix][Number]', 'wt-woocommerce-sequential-order-numbers'),
						'[date][number]'=> __( '[Date][Number]', 'wt-woocommerce-sequential-order-numbers'),
						'[prefix][date][number]'=> __( '[Prefix][Date][Number]', 'wt-woocommerce-sequential-order-numbers'),
					),
				),
				array(
					'title' => __( 'Prefix', 'wt-woocommerce-sequential-order-numbers' ),
					'type' => 'text',
					'desc' => __( 'Prefix will be appended at the beginning of the order number. For eg, if you enter WT- as the prefix with start number as 100, then your first order number will be WT-100.','wt-woocommerce-sequential-order-numbers'),
					'desc_tip' => true,
					'id'	=> 'wt_sequence_order_number_prefix',
					'css' => 'min-width:300px;',

				),
				array(
					'title'    => __( 'Order date format', 'wt-woocommerce-sequential-order-numbers' ),
					'desc'     => sprintf(__("Pick a date format from a list of %s predefined formats %s. You can use alphanumeric characters as separators.", 'wt-woocommerce-sequential-order-numbers'), '<a class="wt_seq_num_frmt_hlp_btn" data-wf-trget="wt_sequence_order_date_prefix">', '</a>'),
					'desc_tip' => __( ' Order date prefix will appear after default prefix', 'wt-woocommerce-sequential-order-numbers' ),
					'id'       => 'wt_sequence_order_date_prefix',
					'type' => 'text',
					'placeholder' => __( 'Choose date format', 'wt-woocommerce-sequential-order-numbers' ),
				),
				array(
					'name' => __( 'Order number length', 'wt-woocommerce-sequential-order-numbers' ),
					'type' => 'number',
					'desc' => __( 'Maintains a fixed length for order number padded with ‘0’ excluding prefix. E.g, Entering order number length as 7 with order number 123 and prefix ‘wt’ will generate a sequential order number as wt0000123.','wt-woocommerce-sequential-order-numbers'),
					'desc_tip' => true,
					'id'	=> 'wt_sequence_order_number_padding',
					'default'  => 0,
					'css' => 'min-width:300px;',
				),
				array(
					'title' => __( 'Start Number', 'wt-woocommerce-sequential-order-numbers' ),
					'type' => 'number',
					'desc_tip' => __( 'The start number will be the first number for your order. For eg, if you enter 100 as starting number, the first order number will be 100.','wt-woocommerce-sequential-order-numbers'),
					'desc' => '<span style="color:#646970; font-size :14px; font-weight:500;">'.__( 'Preview : ', 'wt-woocommerce-sequential-order-numbers' ).'</span>',
					'id'	=> 'wt_sequence_order_number_start',
					'default'  => 1,
					'css' => 'min-width:300px;',
				),
				array(
					'title' => __( 'Apply for all orders', 'wt-woocommerce-sequential-order-numbers' ),
					'desc'    => '<span >&#9888;</span><span style="color:red;">'.__( ' Enable to apply the above format for all existing orders.', 'wt-woocommerce-sequential-order-numbers' ).'</span>',
					'desc_tip' => __( 'Leave it unchecked to apply number format only for new orders.','wt-woocommerce-sequential-order-numbers' ),
					'id'	=> 'wt_renumerate',
					'default' => 'no',
					'type' => 'checkbox',
					'css' => 'min-width:300px;',
				),
				array(
					'title'   => __( 'Track orders', 'wt-woocommerce-sequential-order-numbers' ),
					'desc'    => __( 'Enable', 'wt-woocommerce-sequential-order-numbers' ),
					'id'      => 'wt_custom_order_number_tracking_enabled',
					'desc_tip' => __( 'Enable to track sequential order number if you are currently using shortcode [woocommerce_order_tracking] to track orders.','wt-woocommerce-sequential-order-numbers' ),
					'default' => 'yes',
					'type'    => 'checkbox',
					'css' => 'min-width:300px;',
				),
				array(
					'title'   => __( 'Search orders', 'wt-woocommerce-sequential-order-numbers' ),
					'desc'    => __( 'Enable', 'wt-woocommerce-sequential-order-numbers' ),
					'id'      => 'wt_custom_order_number_search',
					'desc_tip' => __( 'Enable to search the sequential order numbers from WooCommerce orders page.','wt-woocommerce-sequential-order-numbers' ),
					'default' => 'yes',
					'type'    => 'checkbox',
					'css' => 'min-width:300px;',
				),
				array(
					'type' => 'sectionend',
					'id' => 'wts_settings'
				),
			);
		}

		return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings );
	}

	/**
	 *	Output the settings
	 */
	public function output() {

		$settings = $this->get_settings();

		echo '<div class="wt_seq_settings_left">';

		WC_Admin_Settings::output_fields( $settings );

		echo '</div>
			  <div class="wt_seq_settings_right">';
					do_action('wt_seq_settings_right');
		echo '</div>';

		// add free_vs_pro page
		if(isset($_GET['page']) && $_GET['page']=='wc-settings' && isset($_GET['tab']) && $_GET['tab']=='wts_settings' && isset($_GET['section']) && $_GET['section'] =='free_vs_pro')
        {
			do_action('wt_sequential_free_vs_pro_section');
			do_action('wt_sequential_free_vs_pro_section_bottom');
		}
		
	}

	/**
	 *	Process save
	 *
	 *	@return array
	 */
	public function save() {

		global $current_section;

		$settings = $this->get_settings();

		WC_Admin_Settings::save_fields( $settings );

		if ( $current_section !== 'free_vs_pro') 
		{
			Wt_Advanced_Order_Number::save_settings();
		}
		if ( $current_section ) {
			do_action( 'woocommerce_update_options_' . $this->id . '_' . $current_section );
		}


	}
}

endif;

new Wt_Advanced_Order_Number_Settings_Page;
<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('WT_Sequentialordnum_free_to_pro')) :

    /**
     * Class for pro advertisement
     */

    class WT_Sequentialordnum_free_to_pro
    {
        protected $api_url='https://feedback.webtoffee.com/wp-json/wtseqordnum/v1/uninstall';
        protected $current_version=WT_SEQUENCIAL_ORDNUMBER_VERSION;
        protected $auth_key='wtseqordnum_uninstall_1234#';
        protected $plugin_id='wtseqordnum';
        public function __construct()
        {
            add_action('wt_seq_settings_right', array($this, 'show_banners'));

            add_action('wp_ajax_wtsequentialordnum_submit_feature', array($this,"send_feature_suggestion"));
        }

        private function get_suggested_feature() 
        {

            $reasons = array(
                array(
                    'id' => 'pro-feature-suggestion',
                    'text' => __('Other', 'wt-woocommerce-sequential-order-numbers'),
                    'type' => 'textarea',
                    'placeholder' => __('Could you tell us more about the feature?', 'wt-woocommerce-sequential-order-numbers')
                ),
            );

            return $reasons;
        }
        public function show_banners()
        { 
            if(isset($_GET['page']) && $_GET['page']=='wc-settings' && isset($_GET['tab']) && $_GET['tab']=='wts_settings')
            {
                $seq_order_logo_url=WT_SEQUENCIAL_ORDNUMBER_URL.'assets/images/logo.png';
                $reasons = $this->get_suggested_feature();
                ?>
                <style>
                    .wt_gopro_block{ 
                        background: #fff; 
                        height:auto; 
                        padding-left:20px;
                        padding-right:20px; 
                        padding-bottom:10px; 
                        box-sizing:border-box; 
                        box-shadow: 0px 2px 2px #ccc; 
                        margin-top: 20px; 
                        border-top:solid 1px #cccccc; 
                        float: right;
                        }
                    .wt_gopro_block h3{ text-align: center; }
                    .wt_button{
                        font-family: Arial;
                        font-style: normal;
                        font-weight: normal;
                        font-size: 12px;
                        line-height: 15px;
                        text-align: center;
                        background: #5237AC;
                        text-align: center;
                        border-radius: 4px; 
                        box-shadow: 0px 4px 16px rgba(99, 66, 183, 0.35);
                        padding: 4px 10px 4px 10px;
                    }
                    .wt_go_pro_title{
                        font-family: Arial;
                        font-style: normal;
                        font-weight: normal;
                        font-size: 28px;
                        letter-spacing: 0.015em;
                        color: #000000;
                    }
                    .wt_seq_title{
                        background: #F6F4FA;
                        border-radius: 9px; 
                        padding: 10px 10px 10px 8px;
                        margin-bottom: 16px;
                    }
                    .wt_seq_title_val{
                        font-family: Arial;
                        font-style: normal;
                        font-weight: normal;
                        font-size: 16px;
                        line-height: 20px;
                        color: #5237AC;
                        width: 100%;
                        padding-left: 4px;
                    }
                    .wt_seq_pro_features li{
                        font-family: Arial;
                        font-style: normal;
                        font-weight: 300;
                        font-size: 13px;
                        line-height: 19.58px;
                    }
                    .wt_premium_features li::before {
                        font-family: dashicons;
                        text-decoration: inherit;
                        font-weight: 300;
                        font-style: normal;
                        vertical-align: top;
                        text-align: center;
                        content: "\2B50";
                        padding-right: 8px;
                        padding-left: 6px;
                        font-size: 9px;
                        color: #FF9212;
                    }
                    .wt_seq_pro_features{
                        width: 100%;
                        border: 2px solid #F6F4FA;
                        box-sizing: border-box;
                        border-radius: 9px;
                        margin-bottom: 8px;
                    }
                    .wt_suggest_button{
                        text-align: center;
                        padding-top: 8px;
                        padding-bottom: 8px;
                    }
                    .wt_seq_settings_left
                    { 
                        float:left; 
                        width:70%; 
                    }
                    .wt_seq_settings_right{ 
                        float:right; 
                        width:30%; 
                    }
                    p.submit{ 
                        float:left; 
                        width:100%; 
                    }
                </style>
                <div class="wt_gopro_block" id="wtsequentialordnum-wtsequentialordnum-modal">
                    <h3 class="wt_go_pro_title"><?php echo __('Coming soon!','wt-woocommerce-sequential-order-numbers'); ?></h3>

                    <div class="wt_seq_title" style="width: 100%; text-align:center;">
                        <div style="float: left; padding-right: 6px;">
                             <img src="<?php echo esc_url($seq_order_logo_url); ?>" style="max-width:100px;">
                        </div>
                        <div class="wt_seq_title_val">
                            <?php echo __('Sequential Order Number for WooCommerce Pro','wt-woocommerce-sequential-order-numbers'); ?>
                        </div>
                    </div>
                    <div class="wt_seq_pro_features">
                        <ul class="wt_premium_features">
                            <li><?php echo __('Add custom suffix for order numbers','wt-woocommerce-sequential-order-numbers'); ?></li>         
                            <li><?php echo __('Date suffix in order numbers','wt-woocommerce-sequential-order-numbers'); ?></li>         
                            <li><?php echo __('Auto reset sequence per month/year etc.','wt-woocommerce-sequential-order-numbers'); ?></li>         
                            <li><?php echo __('Custom sequence for free orders','wt-woocommerce-sequential-order-numbers'); ?></li> 
                             <li><?php echo __('More order number templates','wt-woocommerce-sequential-order-numbers'); ?></li>         
                            <li><?php echo __('Increment sequence in custom series','wt-woocommerce-sequential-order-numbers'); ?><br/>
                                <span style="padding-left: 22px;">
                                    <?php echo __('and many more','wt-woocommerce-sequential-order-numbers'); ?>
                                </span>
                            </li>                 
                        </ul>
                    </div>
                    <div class="wt_suggest_button">
                        <button class="wt_button" id="wt_suggest" >
                            <span style="color:#ffffff;">
                                <?php echo __('Suggest a feature','wt-woocommerce-sequential-order-numbers'); ?>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="wtsequentialordernum-modal" id="wtsequentialordernum-wtsequentialordernum-modal">
                    <div class="wtsequentialordernum-modal-wrap">
                        <div class="wtsequentialordernum-modal-header">
                            <h3><?php _e('Please tell us about the feature that you want to see next in our plugin', 'wt-woocommerce-sequential-order-numbers'); ?></h3>
                        </div>
                        <div class="wtsequentialordernum-modal-body">
                            <ul class="reasons">
                                <?php 
                                foreach ($reasons as $reason) 
                                {
                                ?>
                                    <li data-type="<?php echo esc_attr($reason['type']); ?>" data-placeholder="<?php echo esc_attr(isset($reason['placeholder']) ? $reason['placeholder'] : ''); ?>">
                                        <?php
                                        if($reason['id']=='pro-feature-suggestion')
                                        {
                                            ?>
                                                <textarea text-align:start; id ="wt_suggested_feature" rows="5" cols="45" value=''></textarea>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                <?php 
                                } 
                                ?>
                            </ul>

                            <div class="wtsequentialordnum_policy_infobox">
                                <?php _e("We do not collect any personal data when you submit this form. It's your feedback that we value.", "wt-woocommerce-sequential-order-numbers");?>
                                <a href="https://www.webtoffee.com/privacy-policy/" target="_blank"><?php _e('Privacy Policy', 'wt-woocommerce-sequential-order-numbers');?></a>        
                            </div>
                        </div>
                        <div class="wtsequentialordernum-modal-footer">
                            <button class="button-primary wtsequentialordernum-model-submit"><?php _e('Submit', 'wt-woocommerce-sequential-order-numbers'); ?></button> 
                            <button class="button-secondary wtsequentialordernum-model-cancel"><?php _e('Cancel', 'wt-woocommerce-sequential-order-numbers'); ?></button>

                        </div>
                    </div>
                </div>
                <style type="text/css">
                    .wtsequentialordernum-modal {
                        position: fixed;
                        z-index: 99999;
                        top: 0;
                        right: 0;
                        bottom: 0;
                        left: 0;
                        background: rgba(0,0,0,0.5);
                        display: none;
                    }
                    .wtsequentialordernum-modal.modal-active {display: block;}
                    .wtsequentialordernum-modal-wrap {
                        width: 50%;
                        position: relative;
                        margin: 10% auto;
                        background: #fff;
                    }
                    .wtsequentialordernum-modal-header {
                        border-bottom: 1px solid #eee;
                        padding: 8px 20px;
                    }
                    .wtsequentialordernum-modal-header h3 {
                        line-height: 150%;
                        margin: 0;
                    }
                    .wtsequentialordernum-modal-body {padding: 5px 20px 5px 20px;}
                    .wtsequentialordernum-modal-body .input-text,.wtsequentialordernum-modal-body textarea {width:75%;}
                    .wtsequentialordernum-modal-body .input-text::placeholder,.wtsequentialordernum-modal-body textarea::placeholder{ font-size:12px; }
                    .wtsequentialordernum-modal-body .reason-input {
                        margin-top: 5px;
                        margin-left: 20px;
                    }
                    .wtsequentialordernum-modal-footer {
                        border-top: 1px solid #eee;
                        padding: 12px 20px;
                        text-align: left;
                    }
                    .wtsequentialordnum_policy_infobox{font-style:italic; text-align:left; font-size:12px; color:#aaa; line-height:14px; margin-top:35px;}
                    .wtsequentialordnum_policy_infobox a{ font-size:11px; color:#4b9cc3; text-decoration-color: #99c3d7; }
                    .sub_reasons{ display:none; margin-left:15px; margin-top:10px; }
                    a.dont-bother-me{ color:#939697; text-decoration-color:#d0d3d5; float:right; margin-top:7px; }
                    .reasons li{ padding-top:5px; }
                </style>
                <script type="text/javascript">
                    (function ($) {
                        $(function () {
                            var modal = $('#wtsequentialordernum-wtsequentialordernum-modal');
                            var deactivateLink = '';
                            $('#wt_suggest').on('click',function (e) {
                                e.preventDefault();
                                modal.addClass('modal-active');
                                modal.find('input[type="radio"]:checked').prop('checked', false);
                            });
                            modal.on('click', 'button.wtsequentialordernum-model-cancel', function (e) {
                                e.preventDefault();
                                modal.removeClass('modal-active');
                            });
                            modal.on('click', 'button.wtsequentialordernum-model-submit', function (e) {
                                e.preventDefault();
                                var button = $(this);
                                if (button.hasClass('disabled')) {
                                    return;
                                }
                                var reason_id='none';
                                var reason_info='';
                                var textarea=document.getElementById("wt_suggested_feature").value;
                                if(textarea !=='')
                                {
                                    reason_id='pro-feature-suggestion';
                                    reason_info=document.getElementById("wt_suggested_feature").value;
                                }
                                $.ajax({
                                    url: ajaxurl,
                                    type: 'POST',
                                    data: {
                                        action: 'wtsequentialordnum_submit_feature',
                                        _wpnonce: '<?php echo wp_create_nonce(WT_SEQUENCIAL_ORDNUMBER_NAME);?>',
                                        reason_id: reason_id,
                                        reason_info: reason_info
                                    },
                                    beforeSend: function () {
                                        button.addClass('disabled');
                                        button.text('Processing...');
                                    },
                                    complete: function () {
                                        modal.removeClass('modal-active');
                                    }
                                });
                            });
                        });
                    }(jQuery));
                </script>
            <?php
        }
    }
     public function send_feature_suggestion()
        {
            global $wpdb;
            $nonce=isset($_POST['_wpnonce']) ? sanitize_text_field($_POST['_wpnonce']) : ''; 
            if(!(wp_verify_nonce($nonce,WT_SEQUENCIAL_ORDNUMBER_NAME)))
            {   
                wp_send_json_error();
            }
            if(!isset($_POST['reason_id']))
            {
                wp_send_json_error();
            }

            $data = array(
                'reason_id' => sanitize_text_field($_POST['reason_id']),
                'plugin' =>$this->plugin_id,
                'auth' =>$this->auth_key,
                'date' => gmdate("M d, Y h:i:s A"),
                'url' => '',
                'user_email' => '',
                'reason_info' => isset($_REQUEST['reason_info']) ? trim(stripslashes(sanitize_text_field($_REQUEST['reason_info']))) : '',
                'software' => $_SERVER['SERVER_SOFTWARE'],
                'php_version' => phpversion(),
                'mysql_version' => $wpdb->db_version(),
                'wp_version' => get_bloginfo('version'),
                'wc_version' => (!defined('WC_VERSION')) ? '' : WC_VERSION,
                'locale' => get_locale(),
                'multisite' => is_multisite() ? 'Yes' : 'No',
                'wtseqordnum_version' =>$this->current_version,
            );
            // Write an action/hook here in webtoffe to recieve the data
            $resp = wp_remote_post($this->api_url, array(
                'method' => 'POST',
                'timeout' => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => false,
                'body' => $data,
                'cookies' => array()
                    )
            );
            wp_send_json_success();
        }
}
new WT_Sequentialordnum_free_to_pro();
    
endif;
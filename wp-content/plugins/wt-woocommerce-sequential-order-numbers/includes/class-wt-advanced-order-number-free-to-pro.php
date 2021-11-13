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
                $tick=WT_SEQUENCIAL_ORDNUMBER_URL.'assets/images/tick.svg';
                $crown=WT_SEQUENCIAL_ORDNUMBER_URL.'assets/images/blue-crown.svg';
                $white_crown=WT_SEQUENCIAL_ORDNUMBER_URL.'assets/images/white-crown.svg';
                $money_back=WT_SEQUENCIAL_ORDNUMBER_URL.'assets/images/money-back.svg';
                $support=WT_SEQUENCIAL_ORDNUMBER_URL.'assets/images/support.svg';
                $reasons = $this->get_suggested_feature();
                ?>
                <style>
                    
                    .wt_button{
                        font-family: Arial;
                        font-style: normal;
                        font-weight: normal;
                        font-size: 12px;
                        line-height: 15px;
                        text-align: center;
                        background: linear-gradient(90.67deg, #2608DF -34.86%, #3284FF 115.74%);
                        text-align: center;
                        border-radius: 4px; 
                        box-shadow: 0px 4px 13px rgba(46, 80, 242, 0.39);
                        padding: 4px 10px 4px 10px;
                        text-decoration: none;
                        transition: all .2s ease;
                        border: none;
                    }
                    .wt_button:hover{
                        box-shadow: 0px 4px 13px rgba(46, 80, 242, 0.5);
                        text-decoration: none;
                        transform: translateY(2px);
                        transition: all .2s ease;
                    }
                    .wt_suggest_button{
                        text-align: center;
                        padding-top: 8px;
                        padding-bottom: 8px;
                    }
                    .wt_seq_settings_left
                    { 
                        float:left; 
                        width:65%; 
                    }
                    .wt_seq_settings_right{ 
                        float:left; 
                        width:30%; 
                        padding-left: 25px;
                    }
                    p.submit{ 
                        float:left; 
                        width:100%; 
                    }
                
                    .wt-seq-sidebar{
                        background: #FFFFFF;
                        border-radius: 7px;
                        padding: 0;
                    }
                    .wt-seq-header{
                        background: #FFFFFF;
                        box-shadow: 0px 4px 19px rgba(49, 117, 252, 0.2);
                        border-radius: 7px;
                        padding: 8px;
                        margin: 0;
                    }
                    .wt-seq-name{
                        background: linear-gradient(87.57deg, #F4F1FF 3%, rgba(238, 240, 255, 0) 93.18%);
                        border-radius: 3px;
                        margin: 0;
                        padding: 16px;
                        display: flex;
                        align-items: center;
                    }
                    .wt-seq-name img{
                        width: 36px;
                        height: auto;
                        box-shadow: 4px 4px 4px rgba(92, 98, 215, 0.23);
                        border-radius: 7px;
                    }
                    .wt-seq-name span{
                        font-style: normal;
                        font-weight: 600;
                        line-height: 16px;
                        margin: 0 0 0 12px;
                        color: #5D63D9;
                        font-size: 15px;
                    }
                    .wt-seq-mainfeatures ul{
                        padding: 0;
                        margin: 15px 25px 20px 25px;
                    }
                    .wt-seq-mainfeatures li{
                        font-style: normal;
                        font-weight: bold;
                        font-size: 14px;
                        line-height:24px;
                        letter-spacing: -0.01em;
                        list-style: none;
                        position: relative;
                        color: #091E80;
                        padding-left: 28px;
                        padding-left: 49px;
                        margin: 0 0 15px 0;
                        display: flex;
                    }
                    .wt-seq-mainfeat li.money-back:before{
                        content: '';
                        position: absolute;
                        left: 10px;
                        height:24px ;
                        width: 16px;
                        background-image: url(<?php echo esc_url($money_back); ?>);
                        background-position: center;
                        background-repeat: no-repeat;
                        background-size: contain;
                    }

                    .wt-seq-mainfeat li.support:before{
                        content: '';
                        position: absolute;
                        left: 10px;
                        height:24px ;
                        width: 16px;
                        background-image: url(<?php echo esc_url($support); ?>);
                        background-position: center;
                        background-repeat: no-repeat;
                        background-size: contain;
                    }
                    .wt-seq-btn-wrapper{
                        display: block;
                        margin: 20px auto 20px;
                        text-align: center;
                    }
                    .wt-seq-blue-btn{
                        background: linear-gradient(90.67deg, #2608DF -34.86%, #3284FF 115.74%);
                        box-shadow: 0px 4px 13px rgba(46, 80, 242, 0.39);
                        border-radius: 5px;
                        padding: 10px 15px 10px 38px;
                        display: inline-block;
                        font-style: normal;
                        font-weight: bold;
                        font-size: 14px;
                        line-height: 18px;
                        color: #FFFFFF;
                        text-decoration: none;
                        transition: all .2s ease;
                        position: relative;
                        border: none;
                    }
                    .wt-seq-blue-btn:before{
                        content: '';
                        position: absolute;
                        height: 15px;
                        width: 18px;
                        background-image: url(<?php echo esc_url($white_crown); ?>);
                        background-size: contain;
                        background-repeat: no-repeat;
                        background-position: center;
                        left: 15px;
                    }
                    .wt-seq-blue-btn:hover{
                        box-shadow: 0px 4px 13px rgba(46, 80, 242, 0.5);
                        text-decoration: none;
                        transform: translateY(2px);
                        transition: all .2s ease;
                    }
                    .wt-seq-features{
                        padding: 40px 30px 25px 30px;
                    }
                    .wt-seq-features ul{
                        padding: 0;
                        margin: 0;
                    }
                    .wt-seq-features li{
                        font-style: normal;
                        font-weight: 500;
                        font-size: 13px;
                        line-height: 17px;
                        color: #001A69;
                        list-style: none;
                        position: relative;
                        padding-left: 49px;
                        margin: 0 0 15px 0;
                        display: flex;
                        align-items: center;
                    }
                    .wt-seq-allfeat li:before{
                        content: '';
                        position: absolute;
                        height: 18px;
                        width: 18px;
                        background-image: url(<?php echo esc_url($tick); ?>);
                        background-size: contain;
                        background-repeat: no-repeat;
                        background-position: center;
                        left: 10px;
                    }
                    ul.wt-seq-newfeat li {
                        margin-bottom: 30px;
                    }
                    .wt-seq-outline-btn{
                        border: 1px solid #007FFF;
                        background: #fff;
                        border-radius: 5px;
                        padding: 10px 15px 10px 38px;
                        display: inline-block;
                        font-style: normal;
                        font-weight: bold;
                        font-size: 14px;
                        line-height: 18px;
                        color: #007FFF;
                        text-decoration: none;
                        transition: all .2s ease;
                        position: relative;
                        background: transparent;
                    }
                    .wt-seq-outline-btn:before{
                        content: '';
                        position: absolute;
                        height: 15px;
                        width: 18px;
                        background-image: url(<?php echo esc_url($crown); ?>);
                        background-size: contain;
                        background-repeat: no-repeat;
                        background-position: center;
                        left: 15px;
                    }
                    .wt-seq-outline-btn:hover{
                        text-decoration: none;
                        transform: translateY(2px);
                        transition: all .2s ease;
                    }
                </style>
                <div class="wt-seq-sidebar">
                    <div class="wt-seq-header">
                      <div class="wt-seq-name">
                        <img src="<?php echo esc_url($seq_order_logo_url); ?>" alt="featured img" width="36" height="36">
                        <span class="wt-product-name"><?php echo __('Sequential Order Number for WooCommerce Pro','wt-woocommerce-sequential-order-numbers'); ?></span>
                      </div>
                      <div class="wt-seq-mainfeatures">
                        <ul class="wt-seq-mainfeat">
                          <li class="money-back"><?php echo __('30 Day Money Back Guarantee','wt-woocommerce-sequential-order-numbers'); ?></li>
                          <li class="support"><?php echo __('Fast and Superior Support','wt-woocommerce-sequential-order-numbers'); ?></li>
                        </ul>
                        <div class="wt-seq-btn-wrapper">
                          <a href="https://www.webtoffee.com/product/woocommerce-sequential-order-numbers/?utm_source=free_plugin_sidebar&utm_medium=sequential_free&utm_campaign=Sequential_Order_Numbers&utm_content=<?php echo WT_SEQUENCIAL_ORDNUMBER_VERSION;?>" class="wt-seq-blue-btn" target="_blank"><?php echo __('UPGRADE TO PREMIUM','wt-woocommerce-sequential-order-numbers'); ?></a>
                        </div>
                      </div>
                    </div>
                    <div class="wt-seq-features">
                      <ul class="wt-seq-allfeat">
                        <li><?php echo __('Add custom suffix for order numbers','wt-woocommerce-sequential-order-numbers'); ?></li>         
                        <li><?php echo __('Date suffix in order numbers','wt-woocommerce-sequential-order-numbers'); ?></li>         
                        <li><?php echo __('Auto reset sequence per month/year etc.','wt-woocommerce-sequential-order-numbers'); ?></li>         
                        <li><?php echo __('Custom sequence for free orders','wt-woocommerce-sequential-order-numbers'); ?></li> 
                         <li><?php echo __('More order number templates','wt-woocommerce-sequential-order-numbers'); ?></li>         
                        <li><?php echo __('Increment sequence in custom series','wt-woocommerce-sequential-order-numbers'); ?>
                      </ul>
                      <div class="wt-seq-btn-wrapper">
                        <a href="https://www.webtoffee.com/product/woocommerce-sequential-order-numbers/?utm_source=free_plugin_sidebar&utm_medium=sequential_free&utm_campaign=Sequential_Order_Numbers&utm_content=<?php echo WT_SEQUENCIAL_ORDNUMBER_VERSION;?>" class="wt-seq-outline-btn" target="_blank">UPGRADE TO PREMIUM</a>
                      </div>
                      <div class="wt_suggest_button">
                        <button class="wt_button" id="wt_suggest" >
                            <span style="color:#ffffff;">
                                <?php echo __('Suggest a feature','wt-woocommerce-sequential-order-numbers'); ?>
                            </span>
                        </button>
                    </div>
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
<?php
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class Wt_Advanced_Order_Number_Activator {

    public static function activate() {

    	do_action("wt_advanced_order_number_activate");
        
    }

}

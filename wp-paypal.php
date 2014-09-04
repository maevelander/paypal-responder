<?php

/*
  Plugin Name: PayPal Responder
  Plugin URI: http://www.wordpress.org/extend/plugins/paypal-responder
  Description: A really simple PayPal plugin. It processes payment for a product via PayPal, then sends an email responder to the customer and returns them to a URL of your choice. That's it.
  Author: Enigma Digital
  Version: 1.1
  Author URI: http://www.enigmaweb.com.au
 */

require 'ipn.php';

add_filter('widget_text', 'do_shortcode');

require 'includes/db-settings.php';

register_activation_hook(__FILE__, 'wp_paypal_db');

add_action('admin_menu', 'wp_paypal_menu');

function wp_paypal_menu() {
    add_menu_page('WP Paypal Products', 'PayPal Resp.', 'manage_options', 'wp-paypal', 'wp_paypal_settings', plugin_dir_url(__FILE__) . "paypal-icon.png");
    add_submenu_page('wp-paypal', '', '', 'manage_options', 'wp-paypal', 'wp_paypal_settings');
    add_submenu_page('wp-paypal', 'Settings', 'Settings', 'manage_options', 'wp-paypal', 'wp_paypal_settings');
    add_submenu_page('wp-paypal', 'Manage Products', 'Manage Products', 'manage_options', 'paypal_products', 'wp_paypal_products');
}

add_action('admin_enqueue_scripts', 'wp_payapl_admin_scripts');

function wp_payapl_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('jquery');
    wp_enqueue_style('wp-paypal-css', plugin_dir_url(__FILE__) . "includes/wp-paypal.css");
    wp_enqueue_style('thickbox');
}

function wp_paypal_products() {
    require 'products/manag-products.php';
}

function wp_paypal_settings() {
    require 'includes/settings.php';
}

add_action('admin_init', 'register_wp_paypal_settings');
add_action('admin_init', 'register_wp_paypal_settings1');

function register_wp_paypal_settings() {
    register_setting('baw-settings-group', 'paypalID');
    register_setting('baw-settings-group', 'currency');
    register_setting('baw-settings-group', 'upload_image');
    register_setting('baw-settings-group', 'return_url');
}

function register_wp_paypal_settings1() {
    register_setting('baw-settings-group1', 'email_subject');
    register_setting('baw-settings-group1', 'email_message');
    register_setting('baw-settings-group1', 'from_email');
}

function wp_paypal_product($atts) {
    extract(shortcode_atts(array(
        'prodname' => 'no value'
                    ), $atts));

    global $wpdb;
    $table = $wpdb->prefix . 'paypal_products';
    $prodname = str_replace('-', ' ', $prodname);
    $shorcode_product = $wpdb->get_row("SELECT * FROM $table WHERE product_name ='$prodname'");
    $product_name = $shorcode_product->product_name;
    $product_price = $shorcode_product->product_price;
    $product_id = $shorcode_product->id;
    $paypalID = get_option('paypalID');
    $currency = get_option('currency');
    $upload_image = get_option('upload_image');
    $return_url = get_option('return_url');
    $email_subject = get_option('email_subject');
    $email_message = get_option('email_message');

    if (!$upload_image) {
        $upload_image = 'http://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif';
    }

    $output = $product_name . '<br>'
            . $product_price . '<br>'
            . $paypalID . '<br>'
            . $currency . '<br>'
            . $upload_image . '<br>'
            . $return_url . '<br>'
            . $email_subject . '<br>'
            . $email_message . '<br>';

    $output = '<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="' . $paypalID . '">
		<input type="hidden" name="return" value="' . $return_url . '">
		<input type="hidden" name="currency_code" value="' . $currency . '">
		<input type="hidden" name="item_name" value="' . $product_name . '">
		<input type="hidden" name="amount" id="p'.$product_id.'" value="' . $product_price . '">
		<input name="notify_url" value="' . plugin_dir_url(__FILE__) . 'ipn.php" type="hidden">
		<input type="image" src="' . $upload_image . '" border="0" name="submit" alt="Make payments with PayPal - its fast, free and secure!"> 
		</form>';
    
    $output .= "<script>jQuery(document).ready(function(){var a=".$product_price.";jQuery('form[name=_xclick]').submit(function(c){var b=jQuery('input[id=p".$product_id."]').val();if(b==a){return}else{c.preventDefault()}})});</script>";

    return $output;
}

add_shortcode('wp-paypal-product', 'wp_paypal_product');
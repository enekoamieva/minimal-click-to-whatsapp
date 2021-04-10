<?php

/*
    Plugin Name: Minimal click to Whatsapp
    Plugin URI:
    Description: A simple and minimal plugin click to Whatsapp
    Version: 1.0.0
    Author: Eneko Amieva
    Author URI: https://enekoamieva.com
    Text Domain: minimal-click-to-whatsapp
    Domain Path: /languages
*/

if(!defined('ABSPATH')) die();

//Int
add_action( 'plugins_loaded', 'mctw_load_textdomain' );
function mctw_load_textdomain() {
    load_plugin_textdomain( 'minimal-click-to-whatsapp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}


//Plugin Activation
register_activation_hook( __FILE__, 'mctw_minimal_click_to_whatsapp_display' );

function mctw_minimal_click_to_whatsapp_display() {

    //Default values
    if( empty( get_option('mctw_settings') ) ) {
        $options = array(
            'position_button'   => 'right',
            'icon_size'         => 42
        );
        update_option( 'mctw_settings', $options );
    }
}


/**
 * ADMIN
 */
require plugin_dir_path( __FILE__ ) . 'admin/minimal-click-to-whatsapp-admin.php';


/**
 * PUBLIC
 */
require plugin_dir_path( __FILE__ ) . 'public/minimal-click-to-whatsapp-public.php';
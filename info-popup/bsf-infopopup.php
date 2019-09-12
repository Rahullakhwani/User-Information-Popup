<?php
/**
 * Plugin Name: User Information Popup
 * Description: To display information entered by a user in the form of a modal popup.
 * Version:     1.0.0
 * Author:      Rahul Lakhwani
 * Author URI:  https://brainstormforce.com
 * Text Domain: info-popup.
 */

define('IP_PATH', __FILE__ );

define('IP_ABSPATH', plugin_dir_path( __FILE__ ) );

define('IP_VERSION', '1.0.0' );

define('IP_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

define('IP_PLUGIN_URL', untrailingslashit( plugins_url('', __FILE__ ) ) );

require_once ( plugin_dir_path(__FILE__).'classes/class-bsfip-loader.php');

/*
*changes done again
*/
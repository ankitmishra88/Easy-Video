<?php
/**
 * Plugin Name:       Easy Video
 * Description:       Easy Video Fetch From Youtube
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP:      7.2
 * Author:            Ankit Mishra
 * Author URI:        https://ankit.codes/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       easy-video
 */

defined('ABSPATH')||die('No Script Kiddies Please');

/**
 * Let's define some constants related to plugin directory
 */

if(!defined('EV_PLUGIN_DIR'))
    define('EV_PLUGIN_DIR',untrailingslashit(dirname(__FILE__)));

if(!defined('EV_PLUGIN_DIR_URL'))
    define('EV_PLUGIN_DIR_URL',untrailingslashit(plugin_dir_url(__FILE__)));

require_once(EV_PLUGIN_DIR.'/classes/class.ev_loader.php');

$GLOBALS['EV_LOADER']=new EV_LOADER();

function ev_loader(){
    return $GLOBALS['EV_LOADER'];
}

?>
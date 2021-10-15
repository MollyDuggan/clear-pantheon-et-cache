<?php

/**
 * Clear Pantheon et-cache
 *
 * @package    clear-pantheon-et-cache
 * @author     Molly Duggan Associates <support.mollyduggan.com>
 * @copyright  2021 Molly Duggan Associates
 * @link       https://wordpress.org/plugins/clear-pantheon-et-cache/
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name:  Clear Pantheon et-cache
 * Plugin URI:   https://wordpress.org/plugins/clear-pantheon-et-cache/
 * Description:  Manually purge the Pantheon~/files/uploads/et-cache directory
 * Author:       Molly Duggan Associates, Erik Cochran, Chris McIntosh
 * Author URI:   https://support.mollyduggan.com
 * Version:      1.0.1
 * Text Domain:  clear-pantheon-et-cache
 * License:     GPL-2.0+
 *
 */

// Block direct access to file
defined( 'ABSPATH' ) or die( 'Not Authorized!' );

// Plugin Defines
define( "WPS_FILE", __FILE__ );
define( "WPS_DIRECTORY", dirname(__FILE__) );
define( "WPS_TEXT_DOMAIN", dirname(__FILE__) );
define( "WPS_DIRECTORY_BASENAME", plugin_basename( WPS_FILE ) );
define( "WPS_DIRECTORY_PATH", plugin_dir_path( WPS_FILE ) );
define( "WPS_DIRECTORY_URL", plugins_url( null, WPS_FILE ) );

// Require the main class file
require_once( WPS_DIRECTORY . '/include/main-class.php' );

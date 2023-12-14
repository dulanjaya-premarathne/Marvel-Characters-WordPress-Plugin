<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://dulanjaya.me
 * @since             1.0.0
 * @package           S_Marvel
 *
 * @wordpress-plugin
 * Plugin Name:       S-Marvel
 * Plugin URI:        https://www.dulanjaya.me
 * Description:       This plugin is created for training purposes using Marvel API. I have created the listing page and the detail page. Just click on the activate button to see how it works.
 * Version:           1.0.0
 * Author:            Dulanjaya
 * Author URI:        https://dulanjaya.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       s-marvel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define('S_MARVEL_PATH', plugin_dir_path(__FILE__));
define('S_MARVEL_ADMIN_PATH', plugin_dir_url(dirname(__FILE__)));
define ('S_MARVEL_LIB_PATH', plugin_dir_url(dirname(__FILE__)).'s-marvel/lib');
define('S_MARVELL_DIR_PATH', plugin_dir_url(dirname(__FILE__)));
error_reporting(E_ALL & ~E_NOTICE); 

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'S_MARVEL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-s-marvel-activator.php
 */
function activate_s_marvel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-s-marvel-activator.php';
	S_Marvel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-s-marvel-deactivator.php
 */
function deactivate_s_marvel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-s-marvel-deactivator.php';
	S_Marvel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_s_marvel' );
register_deactivation_hook( __FILE__, 'deactivate_s_marvel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-s-marvel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_s_marvel() {

	$plugin = new S_Marvel();
	$plugin->run();

}
run_s_marvel();

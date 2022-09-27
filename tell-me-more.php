<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/OllieJones
 * @since             1.0.0
 * @package           Tell_Me_More
 *
 * @wordpress-plugin
 * Plugin Name:       Tell Me More
 * Plugin URI:        https://github.com/OllieJones/tell-me-more
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Oliver Jones
 * Author URI:        https://github.com/OllieJones
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tell-me-more
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TELL_ME_MORE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tell-me-more-activator.php
 */
function activate_tell_me_more() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tell-me-more-activator.php';
	Tell_Me_More_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tell-me-more-deactivator.php
 */
function deactivate_tell_me_more() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tell-me-more-deactivator.php';
	Tell_Me_More_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tell_me_more' );
register_deactivation_hook( __FILE__, 'deactivate_tell_me_more' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tell-me-more.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tell_me_more() {

	$plugin = new Tell_Me_More();
	$plugin->run();

}
run_tell_me_more();

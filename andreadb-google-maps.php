<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           Andreadb_Google_Maps
 *
 * @wordpress-plugin
 * Plugin Name:       Andreadb Google Maps
 * Plugin URI:        http://andreadb91.altervista.org/plugins/andreadb-google-maps/
 * Description:       The easiest way to create responsive Google Maps with multiple markers.
 * Version:           1.0.0
 * Author:            Andreadb
 * Author URI:        http://andreadb91.altervista.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       andreadb-google-maps
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-andreadb-google-maps-activator.php
 */
function activate_andreadb_google_maps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-andreadb-google-maps-activator.php';
	Andreadb_Google_Maps_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-andreadb-google-maps-deactivator.php
 */
function deactivate_andreadb_google_maps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-andreadb-google-maps-deactivator.php';
	Andreadb_Google_Maps_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_andreadb_google_maps' );
register_deactivation_hook( __FILE__, 'deactivate_andreadb_google_maps' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-andreadb-google-maps.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_andreadb_google_maps() {

	$plugin = new Andreadb_Google_Maps();
	$plugin->run();

}
run_andreadb_google_maps();

<?php

/**
 * The plugin bootstrap file
 *
 * Cartogprahy plugin is to create beautiful geo vector maps with animations and display information 
 * on hover, click, and supports multiple color themes.
 *
 * @link              https://pixobe.com
 * @since             1.0.1
 * @package           Pixobe_Cartography
 *
 * @wordpress-plugin
 * Plugin Name:       Pixobe-Cartography
 * Plugin URI:        https://cartography.page
 * Description:       Display animated vector maps of the world, continents or any country in the world.Create animated flight path between markers, show tooltip, click actions and choose different color themes.
 * Version:           1.0.1
 * Author:            Pixobe
 * Author URI:        https://pixobe.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PIXOBE_CARTOGRAPHY_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/Pixobe_Cartography_Activator.php
 */
function activate_pixobe_cartography()
{
	require_once plugin_dir_path(__FILE__) . 'includes/Pixobe_Cartography_Activator.php';
	Pixobe_Cartography_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/Pixobe_Cartography_Deactivator.php
 */
function deactivate_pixobe_cartography()
{
	require_once plugin_dir_path(__FILE__) . 'includes/Pixobe_Cartography_Deactivator.php';
	Pixobe_Cartography_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_pixobe_cartography');
register_deactivation_hook(__FILE__, 'deactivate_pixobe_cartography');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/Pixobe_Cartography.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pixobe_cartography() {

	$plugin = new Pixobe_Cartography();
	$plugin->run();

}
run_pixobe_cartography();

add_shortcode( 'cartography', 'pixobe_cartography_shortcut_fn' );
function pixobe_cartography_shortcut_fn( $atts, $content = "" ) {
	$id = $atts['id'];
    return "<pixobe-cartography id=$id></pixobe-cartography>";
}
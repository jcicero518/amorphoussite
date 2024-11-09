<?php
/**
 * The plugin bootstrap file
 *
 * @link              http://amorphouswebsolutions.com/
 * @since             1.0.0
 * @package           wp-custom-widgets
 *
 * @wordpress-plugin
 * Plugin Name:       WP Custom Widgets
 * Plugin URI:        //
 * Description:       WP Custom Widgets
 * Version:           1.0.0
 * Author:            Jeff Cicero
 * Author URI:        http://amorphouswebsolutions.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-custom-widgets
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'WP_WIDGET_CUSTOM_ASSETS_DIR' ) ) {
	define( 'WP_WIDGET_CUSTOM_ASSETS_DIR', plugins_url( '', __FILE__ ) . '/assets/' );
}

require plugin_dir_path( __FILE__ ) . 'includes/class-wp-custom-widgets.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-related-links-widget.php';

new WPCustomWidgets\WP_Custom_Widgets();


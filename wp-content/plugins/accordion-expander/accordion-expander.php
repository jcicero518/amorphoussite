<?php
/*
Plugin Name: Accordion Expander
Plugin URI:  http://amorphouswebsolutions.com
Description: Testimonial Expander
Version:     1.0
Author:      Jeff Cicero
Author URI:  http://amorphouswebsolutions.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: accordion-expander
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-accordion-expander.php';

$AccordionExpanderInstance = new AccordionExpander;

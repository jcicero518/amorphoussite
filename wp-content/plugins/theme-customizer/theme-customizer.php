<?php
/**
 * Theme Customizer
 *
 * This file should only use syntax available in PHP 5.2.4 or later.
 *
 * @package      Amorphous\ThemeCustomizer
 * @author       Jeff Cicero
 * @copyright    2017 Amorphous
 * @license      GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name:       Theme Customizer
 * Plugin URI:        http://amorphouswebsolutions.com
 * Description:       ...
 * Version:           1.0.0
 * Author:            Jeff Cicero
 * Author URI:        http://amorphouswebsolutions.com
 * Text Domain:       theme-customizer
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/garyjones/...
 * Requires PHP:      7.0
 * Requires WP:       4.7
 */

// Current Version (Keep in sync with Version # above)
define( 'THEME_CUSTOMIZER_CURRENT_VERSION', '1.0.0' );
define( 'THEME_CUSTOMIZER_REQ_PHP', '7.0' );
define( 'THEME_CUSTOMIZER_REQ_WP', '4.8' );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

if ( version_compare( PHP_VERSION, THEME_CUSTOMIZER_REQ_PHP, '<' ) ) {
  if ( current_user_can( 'activate_plugins' ) ) {
    add_action( 'admin_init', 'theme_customizer_deactivate' );
    add_action( 'admin_notices', 'theme_customizer_deactivation_notice' );

    /**
     * Deactivate the plugin.
     */
    function theme_customizer_deactivate() {
      deactivate_plugins( plugin_basename( __FILE__ ) );
    }

    /**
     * Show deactivation admin notice.
     */
    function theme_customizer_deactivation_notice() {
      $notice = sprintf(
      // Translators: 1: Required PHP version, 2: Current PHP version.
        '<strong>Theme Customizer</strong> requires PHP %1$s to run. This site uses %2$s, so the plugin has been <strong>deactivated</strong>.',
        THEME_CUSTOMIZER_REQ_PHP,
        PHP_VERSION
      );
      ?>
      <div class="updated"><p><?php echo wp_kses_post( $notice ); ?></p></div>
      <?php
      if ( isset( $_GET['activate'] ) ) { // WPCS: input var okay, CSRF okay.
        unset( $_GET['activate'] ); // WPCS: input var okay.
      }
    }
  }

  return false;
}

/**
 * Load plugin init
 */
require plugin_dir_path( __FILE__ ) . '/init.php';
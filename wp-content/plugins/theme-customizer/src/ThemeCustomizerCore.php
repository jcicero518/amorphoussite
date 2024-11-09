<?php

namespace Amorphous\ThemeCustomizer;

use Amorphous\ThemeCustomizer\Customizer\Init;
use BrightNucleus\Config\ConfigInterface;
use BrightNucleus\Config\ConfigTrait;
use BrightNucleus\Config\Exception\FailedToProcessConfigException;
use BrightNucleus\Settings\Settings;

class ThemeCustomizerCore {

  use ConfigTrait;

  /**
   * Static instance of the plugin.
   *
   * @since 0.1.0
   *
   * @var self
   */
  protected static $instance;

  /**
   * Instantiate a Plugin object.
   *
   * Don't call the constructor directly, use the `Plugin::get_instance()`
   * static method instead.
   *
   * @since 0.1.0
   *
   * @throws FailedToProcessConfigException If the Config could not be parsed correctly.
   *
   * @param ConfigInterface $config Config to parametrize the object.
   */
  public function __construct() {

  }

  /**
   * Get a reference to the Plugin instance.
   *
   * @since 0.1.0
   *
   * @throws FailedToProcessConfigException If the Config could not be parsed correctly.
   *
   * @param ConfigInterface $config Optional. Config to parametrize the
   *                                object.
   * @return self
   */
  public static function get_instance() {
    if ( ! self::$instance ) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * Launch the initialization process.
   *
   * @since 0.1.0
   */
  public function run() {
    $this->defineHooks();
  }

  // https://premium.wpmudev.org/blog/creating-custom-controls-wordpress-theme-customizer/
  // https://paulund.co.uk/custom-wordpress-controls
  public function defineHooks() {
    add_action( 'customize_register', [ Init::class, 'register' ] );
  }

}
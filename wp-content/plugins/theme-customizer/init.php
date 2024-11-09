<?php
namespace Amorphous\ThemeCustomizer;

use BrightNucleus\Config\ConfigFactory;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

if ( ! defined( 'PLUGIN_SLUG_DIR' ) ) {
  define( 'PLUGIN_SLUG_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'PLUGIN_SLUG_URL' ) ) {
  define( 'PLUGIN_SLUG_URL', plugin_dir_url( __FILE__ ) );
}

// Load Composer autoloader.
if ( file_exists( plugin_dir_path( __FILE__ ) . '/vendor/autoload.php' ) ) {
  require_once plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';
}


$core = new ThemeCustomizerCore();
$core->run();

//$config_file = __DIR__ . 'config/confDefaults.php';
//$config = ConfigFactory::create( $config_file );
//ThemeCustomizerCore::get_instance( $config->getSubConfig( 'Amorphous\ThemeCustomizer') )->run();
//var_dump($config);
//ThemeCustomizerCore::get_instance( $config->getSubConfig( 'Amorphous\ThemeCustomizer' ) );
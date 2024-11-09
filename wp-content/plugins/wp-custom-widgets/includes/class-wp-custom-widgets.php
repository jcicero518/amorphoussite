<?php

namespace WPCustomWidgets;

/**
 * Registers widget for inclusion in Wordpress
 *
 * Class WP_Custom_Widgets
 * @package WPCustomWidgets
 */
class WP_Custom_Widgets {

	const WIDGET_CLASSNAME = 'RelatedLinksWidget';

	public function __construct() {
		$this->enqueueAssets();
		$this->registerWidgets();
	}

	private function enqueueAssets() {
		add_action( 'admin_enqueue_scripts', function() {
			wp_enqueue_style( 'fa', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
			wp_enqueue_script( 'wp-custom-widgets-admin', WP_WIDGET_CUSTOM_ASSETS_DIR . 'js/admin.js', [], '1.0', true );
		});
	}

	private function registerWidgets() {
		add_action( 'widgets_init', function() {
			register_widget( __NAMESPACE__ . '\\' . self::WIDGET_CLASSNAME );
		});
	}
}

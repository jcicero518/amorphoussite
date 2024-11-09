<?php

namespace lib\Hooks;

use lib\Abstracts\InitDefaults;

class HookInits extends InitDefaults {

	public function defineActions() {
		add_action( 'widgets_init', [ __CLASS__, 'theme_widgets_init' ] );
	}

	public function defineDefaultSettings() {
		 return [
			'widget' => [
				'before_widget' => '<section class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
				'description'   => esc_html__( 'Add widgets here.', 'amorphous' )
			]
		];
	}

	protected function getDefaultSettings() {
		return self::defineDefaultSettings();
	}

	public function theme_widgets_init() {
		$defaults = HookInits::getDefaultSettings();
		$widgetDefaults = $defaults['widget'];

		register_sidebar( array_merge([
			'name'          => esc_html__( 'Sidebar', 'amorphous' ),
			'id'            => 'sidebar-1'
			], $widgetDefaults
		));

		register_sidebar( array_merge([
			'name'          => esc_html__( 'Footer Left', 'amorphous' ),
			'id'            => 'footer-left',
			], $widgetDefaults
		));

		register_sidebar( array_merge([
			'name'          => esc_html__( 'Footer Right', 'amorphous' ),
			'id'            => 'footer-right',
			], $widgetDefaults
		));
	}
}
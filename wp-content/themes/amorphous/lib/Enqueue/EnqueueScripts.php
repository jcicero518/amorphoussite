<?php

namespace lib\Enqueue;

use lib\Menu\MenuWalker;
use lib\Abstracts\InitDefaults;

/**
 * Class EnqueueScripts
 *
 * Handles script enqueueing and localization.
 *
 * @package lib\Enqueue
 */
class EnqueueScripts extends InitDefaults {
	/**
	 * @var bool $enqueued
	 * Flag to prevent duplicate instantiations
	 */
	protected static $enqueued = FALSE;

	/**
	 * Define actions for this class.
	 * @return void
	 */
	public function defineActions() {
		if ( !$this->isEnqueued() ) {
			add_action( 'wp_enqueue_scripts', [ __CLASS__, 'theme_scripts' ] );
		}
	}

	public function defineDefaultSettings() {
		// TODO: Implement defineDefaultSettings() method.
	}

	/**
	 * @return boolean
	 */
	public function isEnqueued() {
		return self::$enqueued;
	}

	/**
	 *  wp_enqueue_scripts action body
	 */
	public function theme_scripts() {
		global $wp_scripts;
		global $post;
		$isProduction = TRUE;
		// https://www.gatsbyjs.org/blog/2017-10-20-from-wordpress-to-developing-in-react-starting-to-see-it/
		// https://indigotree.co.uk/

		if ( !is_admin() ) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js', array(), '', true );
		}

		wp_enqueue_style( 'amorphous-style', get_stylesheet_uri() );
		wp_enqueue_style( 'fa', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
		//wp_enqueue_style( 'slider-css', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.2.4/tiny-slider.css' );
		//wp_enqueue_script( 'build-page', get_stylesheet_directory_uri() . '/dist/pagination.bundle.js', array(), '', true );

		if ( $isProduction ):
			wp_enqueue_style( 'extracted-css', get_stylesheet_directory_uri() . '/buildProd/dist/styles.css' );
			wp_enqueue_script( 'build-vendor', get_stylesheet_directory_uri() . '/buildProd/dist/vendor.bundle.js', array(), '', true );
			wp_enqueue_script( 'build-main', get_stylesheet_directory_uri() . '/buildProd/dist/app.bundle.js', array(), '', true );
		else:
			wp_enqueue_style( 'extracted-css', get_stylesheet_directory_uri() . '/dist/styles.css' );
			wp_enqueue_script( 'build-vendor', get_stylesheet_directory_uri() . '/dist/vendor.bundle.js', array(), '', true );
			wp_enqueue_script( 'build-main', get_stylesheet_directory_uri() . '/dist/app.bundle.js', array(), '', true );
		endif;

		wp_localize_script( 'build-main', 'globalPost', [
			'postID' => $post->ID
		]);

		$mainMenu = wp_nav_menu( array(
			'echo' => FALSE,
			'menu' => 'Main',
			'theme_location' => 'menu-1',
			'container' => FALSE,
			'menu_class' => 'navbar-menu navbar-end',
			'walker' => new MenuWalker()
		) );
		wp_localize_script( 'build-main', 'mainMenu', $mainMenu );
		wp_localize_script( 'build-main', 'themeApi', [
			'home' => home_url(),
			'theme' => get_stylesheet_directory_uri(),
			'images' => get_stylesheet_directory_uri() . '/assets/images/',
			'main' => home_url( '', 'rest' ) . '/wp-json/',
			'rest' => home_url( '', 'rest' ) . '/wp-json/amorphous-theme/v1/'
		]);
		wp_localize_script( 'build-main', 'themeNavMap', [
			'about' => 'menu-page-id-2',
			'code'  => 'menu-page-id-16',
			'portfolio' => 'menu-page-id-27',
			'contact' => 'menu-page-id-39'
		]);

		$queried_object = get_queried_object();
		$local = [
			'queriedObject' => $queried_object
		];
		$local['taxonomy'] = get_taxonomy( $queried_object->taxonomy );

		wp_localize_script( 'build-main', 'settings', $local );

		self::$enqueued = TRUE;
	}
}
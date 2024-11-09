<?php

namespace lib\Hooks;

class SiteLoad {

  public function __construct() {
    self::trimWPHead();
  }

  public static function trimWPHead() {
    /**
     * Remove WP Generator
     * <meta name="generator" content="WordPress 4.8.2">
     */
    remove_action( 'wp_head', 'wp_generator' );
    /**
     * Remove EditURI link
     * <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://.../xmlrpc.php?rsd">
     */
    remove_action( 'wp_head', 'rsd_link' );
    /**
     * Remove wlmanifest link
     * <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://.../wp-includes/wlwmanifest.xml">
     */
    remove_action( 'wp_head', 'wlwmanifest_link' );
    /**
     * Remove post feed links
     */
    remove_action( 'wp_head', 'feed_links', 2 );
    /**
     * Remove category feeds
     */
    remove_action( 'wp_head', 'feed_links_extra', 3 );
    /*remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);

    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);*/
    /**
     * Remove WP version from styles and scripts
     */
    add_filter( 'style_loader_src', [ __CLASS__, 'filter_wp_css_js_ver' ], 9999 );
    add_filter( 'script_loader_src', [ __CLASS__, 'filter_wp_css_js_ver' ], 9999 );
    /**
     * Remove WP version from RSS
     */
    add_filter( 'the_generator', [ __CLASS__, 'filter_rss_version' ] );

    /**
     * Clean comment styles
     */
    add_action( 'wp_head', [ __CLASS__, 'filter_comment_styles' ], 1 );
  }

  /**
   * Filters out version from src string.
   *
   * @param $src
   * @return string
   */
  public function filter_wp_css_js_ver( $src ) {
    if ( strpos( $src, 'ver=' ) ) {
      $src = remove_query_arg( 'ver', $src );
    }
    return $src;
  }

  /**
   * Filters out WP version appended to any RSS feeds
   *
   * @return string
   */
  public function filter_rss_version() {
    return '';
  }

  /**
   * Filters out "recent comments" added automatically
   */
  public function filter_comment_styles() {
    global $wp_widget_factory;
    if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
      remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
    }
  }
}
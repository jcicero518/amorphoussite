<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package amorphous
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php do_action( 'theme_analytics_gtag_head' ); ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'amorphous' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) : ?>
				<!--<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>-->
			<?php
			endif;
			?>
		</div><!-- .site-branding -->

	</header><!-- #masthead -->
	<nav id="site-navigation" class="main-navigation navbar">
		<div class="container">
			<div class="navbar-brand">
				<!--<a class="navbar-item" href="/">Amorphous Web Solutions</a>-->
				<a class="navbar-item" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img width="182" height="117" alt="Home" src="<?= get_stylesheet_directory_uri() . '/assets/images/logo-white182.png'; ?>" />
				</a>
				<button class="button navbar-burger" data-target-class="navbar-menu">
					<span></span>
					<span></span>
					<span></span>
				</button>
			</div>
			<div class="navbar-menu">
				<?php
				$menu = wp_nav_menu( array(
					'menu' => 'Main',
					'theme_location' => 'menu-1',
					'container' => FALSE,
					'menu_class' => 'navbar-menu navbar-end',
					'walker' => new lib\Menu\MenuWalker()
				) );
				//add_filter('nav_menu_item_args')
				?>
			</div>
		</div>
	</nav>
	<div id="sticky-span"></div>
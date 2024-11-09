<?php
/**
 * Template Name: Query
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amorphous
 */
global $post;
global $wp_query;
$layoutFilter = new lib\Filters\Layout( $post );
$siteQueryInstance = new lib\Query\SiteQuery( ['posts_per_page' => 3] );
$siteQueryInstance->loop();
//var_dump($siteQueryInstance->getQuery());
get_header(); ?>

	<section class="section">
		<div class="container">
			<?= apply_filters( 'theme_page_layout', [ 'layout' => $layoutFilter->getLayout() ] ); ?>
		</div>
	</section>

<?php
get_footer();

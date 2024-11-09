<?php
/**
 * Template Name: Code
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amorphous
 */
global $post;
$layoutFilter = new lib\Filters\Layout( $post );
get_header(); ?>

	<section class="section">
		<div class="container">
			<?= apply_filters( 'theme_page_layout', [
				'layout' => $layoutFilter->getLayout(),
				'postType' => 'card'
			] );
			?>
		</div>
	</section>
	<!--<div id="app"></div>-->

<?php
get_footer();

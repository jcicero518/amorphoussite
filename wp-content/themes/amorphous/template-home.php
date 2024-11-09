<?php
/**
 * Template Name: Home Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amorphous
 */

get_header(); ?>
	<section class="section">
		<div class="container">
			<div class="box">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php //the_title( '<h1 class="title">', '</h1>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->


					<footer class="entry-footer"></footer>
				</article>
			</div>
		</div>
	</section>
	<!--<div id="app"></div>-->

<?php
//get_sidebar();
get_footer();

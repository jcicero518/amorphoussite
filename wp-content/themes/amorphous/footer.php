<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package amorphous
 */

?>

	<footer id="colophon" class="site-footer footer">
		<section class="section">
			<div class="container">
				<div class="columns is-clearfix">
					<div class="column is-6">
						<p>&copy; <?= date( 'Y' ); ?> Amorphous Web Solutions</p>
						<?php dynamic_sidebar('footer-left'); ?>
					</div>
					<div class="column is-6">
						<?php dynamic_sidebar('footer-right'); ?>
					</div>
				</div>
				<div class="site-info">

				</div><!-- .site-info -->
			</div>
		</section>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

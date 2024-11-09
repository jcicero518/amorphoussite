<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amorphous
 */
?>

<div class="columns">
	<div class="columns is-12">
		<div class="box">
			<header class="entry-header">
				<?php

				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">{ ', ' }</h1>' );
				else :
					the_title( '<h2 class="subtitle"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;

				if ( 'post' === get_post_type() || 'site' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php //amorphous_posted_on(); ?>
					</div><!-- .entry-meta -->
					<div class="entry-meta">
						<?php amorphous_term_list( get_the_ID(), 'site_category' ); ?>
					</div>
					<?php

				endif; ?>
			</header><!-- .entry-header -->

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content">
						<?php
						echo wp_get_attachment_image( get_field( 'site_image' )['id'], 'large', false, [
							'class' => 'alignright'
						] );

						the_content( sprintf(
							wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'amorphous' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						) );


						?>
					</div><!-- .entry-content -->

					<footer class="entry-footer">

					</footer><!-- .entry-footer -->
				</article><!-- #post-<?php the_ID(); ?> -->
		</div>
	</div>
</div>


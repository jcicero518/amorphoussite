<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package amorphous
 */

get_header(); ?>

	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="column is-two-thirds">
					<div class="box">
						<?php
						global $wp_query;
						$args = array_merge( $wp_query->query_vars, [
							'post_type' => 'card',
							'posts_per_page' => 10
						]);
						$categoryQuery = new WP_Query( $args );
						if ( $categoryQuery->have_posts() ) : ?>

							<header class="page-header">
								<?php

								the_archive_title( '<h1 class="title">', '</h1>' );
								the_archive_description( '<div class="archive-description">', '</div>' );
								?>
							</header><!-- .page-header -->

							<?php
							/* Start the Loop */
							while ( $categoryQuery->have_posts() ) : $categoryQuery->the_post();

								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<header class="entry-header">
										<h2 class="title">
											<a href="<?= esc_url( get_permalink( $categoryQuery->post->ID ) ); ?>"><?= get_the_title( $categoryQuery->post->ID); ?></a>
										</h2>
										<?php
										if ( 'post' === get_post_type() || 'card' === get_post_type() ) : ?>
											<div class="entry-meta">
												<span class="tag is-info">Topics</span> <?= get_the_category_list( ', ' ); ?>
											</div>
											<?php
										endif;
										?>
									</header>
									<div class="entry-content">
										<?= get_the_excerpt( $categoryQuery->post->ID ); ?>
									</div>
								</article>

							<?php
							endwhile;

							the_posts_navigation();

						endif;
						wp_reset_postdata();
						?>
					</div>
				</div>
				<div class="column">
					<div class="box">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>

		</div><!-- #main -->
	</section><!-- #primary -->

<?php
//get_sidebar();
get_footer();

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
						if ( get_query_var('paged') ) {
							$paged = get_query_var('paged');
						} elseif ( get_query_var('page') ) { // 'page' is used instead of 'paged' on Static Front Page
							$paged = get_query_var('page');
						} else {
							$paged = 1;
						}
						$args = array_merge( $wp_query->query_vars, [
							'post_type' => 'card',
							'posts_per_page' => 5,
							'paged' => $paged
						]);

						$categoryQuery = new WP_Query( $args );
						if ( $categoryQuery->have_posts() ) : ?>

							<header class="page-header">
								<?php
								the_archive_title( '<h1 class="title">{ ', ' }</h1>' );
								the_archive_description( '<div class="archive-description">', '</div>' );

								?>
							</header><!-- .page-header -->
							<div class="entry-content">
								<?= apply_filters( 'theme_display_posts', [
									'postType' => 'card',
									'category' => strtolower( single_term_title( '', false ) )
								] );
								?>
							</div>
							<?php
							/* Start the Loop */
							/*while ( $categoryQuery->have_posts() ) : $categoryQuery->the_post();

								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<header class="entry-header">
										<h2 class="title">
											<a href="<?= esc_url( get_permalink( $categoryQuery->post->ID ) ); ?>"><?= get_the_title( $categoryQuery->post->ID); ?></a>
										</h2>
										<?php amorphous_term_list( get_the_ID(), 'code_category' ); ?>
									</header>
									<div class="entry-content">
										<?= get_the_excerpt( $categoryQuery->post->ID ); ?>
									</div>
								</article>

							<?php
							endwhile;

							//the_posts_navigation();
							theme_page_navi( $categoryQuery );*/

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

<?php

namespace lib\Filters;

use WP_Post;
use lib\Posts\Card;

class Layout {

	protected $layout;
	protected $postId;

	public function __construct( WP_Post $post ) {
		$this->setPostId( $post->ID );
		$this->setLayout();
		$this->initFilters();
	}

	public function initFilters() {
		add_filter( 'theme_page_layout', function( $layoutArgs = [] ) {
			$category = isset( $layoutArgs['category'] ) ? $layoutArgs['category'] : NULL;
			$postType = isset( $layoutArgs['postType'] ) ? $layoutArgs['postType'] : NULL;

			switch ( $layoutArgs['layout'] ) {
				case 'twocol':
					?>
					<div class="columns main-flex-columns">
						<div class="column is-9 is-main-content main-flex-column">
							<div class="box">
								<?php
								while ( have_posts() ) : the_post();
									?>
									<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
										<header class="entry-header">
											<?php the_title( '<h1 class="title">{ ', ' }</h1>' ); ?>
										</header><!-- .entry-header -->

										<div id="content-replace" class="entry-content replace-content">
											<?php the_content(); ?>
											<?php if ( $postType ): ?>
												<?= apply_filters( 'theme_display_posts', [ 'postType' => $postType ] ); ?>
											<?php endif; ?>
										</div><!-- .entry-content -->

										<footer class="entry-footer">
											
										</footer><!-- .entry-footer -->

									</article><!-- #post-<?php the_ID(); ?> -->
									<?php
									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;

								endwhile; // End of the loop.

								if ( is_front_page() ):
									?>

									<?php
									$cardArgs = [
										'post_type' => 'card',
										'posts_per_page' => 3,
										'meta_key' => 'is_featured',
										'meta_value' => 'yes',
										'orderby' => 'date',
										'order' => 'DESC'
									];

									$cardQuery = new \WP_Query( $cardArgs );
									if ( $cardQuery->have_posts() ):
										?>
										<section class="featured-columns">
											<h2 class="title"><span class="fa fa-code" aria-hidden="true"></span> Featured Posts</h2>
											<div class="columns">
												<?php
												while ( $cardQuery->have_posts() ):
													$cardQuery->the_post();
													?>
													<div class="column">
														<div class="card is-animated has-slide-up">
															<div class="entry-header card-header">
																<p class="card-header-title" style="margin-bottom:0"><?= get_the_title( $cardQuery->post->ID ); ?></p>
															</div>
															<div class="card-content">
																<div class="content">
																	<?= get_the_excerpt( $cardQuery->post->ID ); ?>
																</div>
															</div>
														</div>
													</div>
													<?php
												endwhile;
												wp_reset_postdata();
												wp_reset_query();
												?>
											</div>
										</section>

										<?php
									endif;
								endif;

								//$cards = new Card();
								//$output = $cards->getQuery();
								theme_page_navi();
								?>

							</div>

						</div>
						<div class="column main-flex-column">
							<div class="box">
								<?php get_sidebar(); ?>
							</div>
						</div>
					</div>
					<?php
				break;
				case 'full':
					?>
					<div class="box">
						<?php
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
					</div>
					<?php
				break;
			}
		}, 10, 1 );
	}

	private function setPostId( $postId ) {
		$this->postId = $postId;
	}

	public function setLayout() {
		$acfLayout = get_field( 'layout', $this->postId );
		$this->layout = ( !empty( $acfLayout ) ) ? $acfLayout : 'twocol';
	}

	public function getLayout() : string {
		return $this->layout;
	}
}
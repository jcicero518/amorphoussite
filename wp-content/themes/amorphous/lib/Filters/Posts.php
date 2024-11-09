<?php

namespace lib\Filters;

use lib\Posts\Card;

class Posts {

	public function __construct() {
		$this->initFilters();
	}

	private function initFilters() {
		add_filter( 'excerpt_more', [ __CLASS__, 'theme_excerpt_more' ], 10, 1 );
		add_filter( 'alt_page_title', function( $title ) {

		});
		add_filter( 'pre_get_posts', function( \WP_Query $query ) {
			$ignore = ( is_admin() || !$query->is_search() );
			if ( !$ignore && $query->is_search() ):
				$query->set( 'post_type', [ 'page', 'card', 'site' ] );
			endif;
		});
		add_filter( 'theme_display_cards', function( $args = [] ) {
			$category = isset( $args['category'] ) ? $args['category'] : 'ALL';

			ob_start();

			$cards = new Card();
			echo $cards->getQuery();

			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}, 10, 1);

		add_filter( 'theme_display_sites', function( $args = [] ) {

		});

		add_filter( 'theme_display_posts', function( $args = [] ) {
			$category = isset( $args['category'] ) ? $args['category'] : NULL;
			$postType = isset( $args['postType'] ) ? $args['postType'] : NULL;

			ob_start();

			if ( get_query_var('paged') ) {
				$paged = get_query_var('paged');
			} elseif ( get_query_var('page') ) { // 'page' is used instead of 'paged' on Static Front Page
				$paged = get_query_var('page');
			} else {
				$paged = 1;
			}

			$args['post_type'] = $postType;
			$args['paged'] = $paged;
			$args['posts_per_page'] = 5;

			if ( $category && $postType === 'card' ) {
				$args['tax_query'] = [[
					'taxonomy' => 'code_category',
					'field' => 'slug',
					'terms' => $category
				]];
			}

			if ( $postType === 'site' ) {
				$args['meta_key'] = 'site_order';
				$args['order_by'] = 'meta_value_num';
				$args['order'] = 'ASC';
			}

			$query = new \WP_Query( $args );

			if ( $postType === 'site' ) {
              ?>
              <h2 class="title">Recent Work</h2>
              <?php
				$this->theme_display_sites( $query );
				return;
			}
			?>
			<div id="content-inner-replace" class="boxes-container replace-<?= $postType; ?>">
				<div class="cssload-clock"></div>
			</div>

			<?php
			theme_page_navi( $query );
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}, 10, 1);
	}

	function theme_excerpt_more( $more ) {
		global $post;
		$more = "<br /><br />";
		$more .= '<a class="button" href="' . get_permalink( $post->ID ) . '">Read More &raquo;</a>';
		$more .= '';
		return $more;
	}

	function theme_display_sites( \WP_Query $query ) {

		if ( $query->have_posts() ): ?>
          <div class="boxes-container">
			  <div class="tabs is-centered" role="tablist" aria-multiselectable="false" data-tabs-root>

					  <ul role="tablist">
						  <li class="is-active" role="presentation">
							  <a href="#" class="tab" id="site_tab_0" role="tab" aria-controls="site_content_1" tabindex="0" aria-selected="true">
								  <span class="icon is-small"><i class="fa fa-code-fork"></i></span>
								  <span>Freelance</span>
							  </a>
						  </li>
						  <li role="presentation">
							  <a href="#" class="tab" id="site_tab_1" role="tab" aria-controls="site_content_2" tabindex="-1" aria-selected="false">
								  <span class="icon is-small"><i class="fa fa-code-fork"></i></span>
								  <span>Agency</span>
							  </a>
						  </li>
					  </ul>

				  <div class="tabs-container">
					  <div class="tab-panel"
						   role="tabpanel"
						   aria-controls="site_content_1"
						   aria-labelledby="site_tab_0"
						   aria-hidden="false"
						   aria-expanded="true">
						  <?php
						  $args = wp_parse_args( [ 'tag' => 'freelance' ], $query->query_vars );
						  $siteQuery = new \lib\Query\SiteQuery( $args );
						  $this->theme_site_query( $siteQuery );
						  ?>
					  </div>
					  <div class="tab-panel"
						   role="tabpanel"
						   aria-controls="site_content_2"
						   aria-labelledby="site_tab_1"
						   aria-hidden="true"
						   aria-expanded="false">
						  <?php
						  $args = wp_parse_args( [ 'tag' => 'zone5', 'posts_per_page' => '10' ], $query->query_vars );
						  $siteQuery = new \lib\Query\SiteQuery( $args );
						  $this->theme_site_query( $siteQuery );
						  ?>
					  </div>
				  </div>

			  </div>
          </div>
          <?php
        endif;
	}

	function theme_site_query( \WP_Query $query ) {
		while ( $query->have_posts() ):
			$query->the_post();
			$siteImageField = get_field( 'site_image' );
			$siteDetails = get_field( 'site_details' );
			$siteImages = [
				'id' => $siteImageField['id'],
				'caption' => $siteImageField['caption'],
				'thumbnail' => $siteImageField['sizes']['thumbnail'],
				'full' => $siteImageField['url']
			];
			?>
			<div class="card box--site">
				<header class="card-header">
					<p class="card-header-title"><?= get_the_title( $query->post->ID ); ?></p>
				</header>
				<div class="columns">
					<div class="column">
						<div class="card-content">
							<h2 class="title">Project Details</h2>
							<div>
								<div class="entry-meta">
									<?php amorphous_site_term_list( $query->post->ID, 'site_category' ); ?>
								</div>
							</div>
							<div class="is-divider has-no-border"></div>
							<h2 class="title has-inline-below">Full Site</h2>
							<div>
								<a target="_blank" title="Opens in new window" href="<?= get_field( 'site_url'); ?>"><?= get_field( 'site_url' ); ?></a>
							</div>
						</div>
					</div>
					<div class="is-divider-vertical" data-content="<>"></div>
					<div class="column">
						<div class="card-image">
							<figure
								class="image card-image-figure square"
								style="background-image: url(<?= $siteImages['thumbnail']; ?>)"
								data-image-full="<?= $siteImages['full']; ?>">
								<img src="<?= $siteImages['thumbnail'] ?>" />
							</figure>
						</div>
					</div>
				</div>
			</div>
			<?php
		endwhile;
	}
}
<?php

namespace lib\Posts;

use WP_Query;
use lib\Posts\PostInterface;

class Card implements PostInterface {

	protected $args = [];
	protected $postType = 'card';
	private $query;


	public function __construct() {
		$this->setQuery();
	}

	public function getPostType() {
		return $this->postType;
	}

	public function getQuery() {
		$cards = $this->query;
		if ( $cards->have_posts() ):
			?>
			<div class="card">
				<?php
				while ( $cards->have_posts() ):
					$cards->the_post();

					?>
					<header class="card-header">
						<p class="card-header-title"><?= get_the_title( $cards->post->ID ); ?></p>
					</header>
					<div class="card-content">
						<div class="content">
							<?= get_the_excerpt( $cards->post->ID ); ?>
						</div>
					</div>
					<!--<footer class="card-footer">
						<a href="#" class="card-footer-item">Save</a>
						<a href="#" class="card-footer-item">Edit</a>
						<a href="#" class="card-footer-item">Delete</a>
					</footer>-->
					<?php
				endwhile;
				?>
			</div><!--/.card -->
			<?php
		endif;
	}

	public function setQuery() {
		$args = [
			'post_type' => $this->getPostType()
		];

		$this->query = new WP_Query( $args );
	}
}
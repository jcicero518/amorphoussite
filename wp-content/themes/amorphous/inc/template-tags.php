<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package amorphous
 */

if ( ! function_exists( 'amorphous_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function amorphous_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'amorphous' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'amorphous' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

function amorphous_term_list( $postId, $tax = 'code_category', $isLinked = TRUE ) {
	$get_term_tag_list = function( $postId, $tax, $isLinked ) {
		$terms = get_the_terms( $postId, $tax );

		if ( $isLinked ):
			foreach ( $terms as $term ) {
				?>
				<a class="tag is-link"
				   title="<?= $term->name; ?>"
				   href="<?= get_term_link( $term->term_id, $tax); ?>"><?= $term->name; ?></a>
				<?php
			}
		else:
			foreach ( $terms as $term ) {
				?>
				<span class="tag is-medium is-info"><?= $term->name; ?></span>
				<?php
			}
		endif;
	};
	?>

	<div class="field is-grouped is-grouped-multiline">
		<div class="control">
			<div class="tags has-addons">
				<?php if ( $isLinked ): ?>
					<p><label>Topics:</label> <?= $get_term_tag_list( $postId, $tax, $isLinked ) ?></p>
				<?php else: ?>
					<?= $get_term_tag_list( $postId, $tax, $isLinked ) ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}

function amorphous_site_term_list( $postId, $tax = 'site_category' ) {
	$get_term_tag_list = function( $postId, $tax ) {
		$terms = get_the_terms( $postId, $tax );

		foreach ( $terms as $term ) {
			?>
			<span class="tag is-medium is-info"><?= $term->name; ?></span>
			<?php
		}
	};
	?>

	<div class="tags">
		<?= $get_term_tag_list( $postId, $tax, $isLinked ) ?>
	</div>
	<?php
}

if ( ! function_exists( 'amorphous_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function amorphous_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'amorphous' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'amorphous' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'amorphous' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'amorphous' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'amorphous' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'amorphous' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

function theme_page_navi( $postQuery = NULL ) {
	global $wp_query;

	$bignum = 999999999;
	// if no WP_Query instance is passed, assign $postQuery to $wp_query global
	if ( empty( $postQuery ) ) {
		$postQuery = $wp_query;
	}

	// get current page and total number of pages to display
	$current = $postQuery->get( 'paged', 1 );
	$total = isset( $postQuery->max_num_pages ) ? intval( $postQuery->max_num_pages ) : 1;

	// <= 1 pages to display, just output pagination "placeholder" for js
	if ( $total <= 1 ) {
		echo '<nav class="pagination l-pagination"></nav>';
		return;
	}


	echo '<nav class="pagination l-pagination">';
	echo paginate_links( array(
		'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
		'format'       => '',
		'current'      => max( 1, $current ),
		'total'        => $total,
		'prev_text'    => '&larr;',
		'next_text'    => '&rarr;',
		'type'         => 'list',
		'end_size'     => 3,
		'mid_size'     => 3
	) );
	echo '</nav>';
}

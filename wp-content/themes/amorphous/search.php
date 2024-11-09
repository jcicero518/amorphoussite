<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package amorphous
 */

get_header(); ?>
	<section class="section">
		<div class="container">
			<div class="columns">
				<div class="columns is-12">
					<div class="box">

						<?php
						if ( have_posts() ) : ?>

							<header class="page-header">
								<h1 class="page-title"><?php
									/* translators: %s: search query. */
									printf( esc_html__( 'Search Results for: %s', 'amorphous' ), '<span>' . get_search_query() . '</span>' );
								?></h1>
							</header><!-- .page-header -->

							<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								/**
								 * Run the loop for the search to output the results.
								 * If you want to overload this in a child theme then include a file
								 * called content-search.php and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'search' );

							endwhile;

							the_posts_navigation();

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php
//get_sidebar();
get_footer();

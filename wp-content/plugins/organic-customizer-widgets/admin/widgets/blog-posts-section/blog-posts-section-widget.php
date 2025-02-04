<?php
/* Registers a widget to show a Team subsection on a page */

// Block direct requests.
if ( !defined('ABSPATH') )
	die('-1');


/**
 * Adds Organic_Widgets_Blog_Posts_Section_Widget widget.
 */
class Organic_Widgets_Blog_Posts_Section_Widget extends Organic_Widgets_Custom_Widget {

	const CUSTOM_IMAGE_SIZE_SLUG = 'organic_widgets_widget_image_upload';

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'organic_widgets_blog_posts_section', // Base ID
			__( 'Organic Blog Posts', ORGANIC_WIDGETS_18N ), // Name
			array(
				'description' => __( 'A section displaying recent blog posts.', ORGANIC_WIDGETS_18N ),
				'customize_selective_refresh' => true,
			) // Args
		);

		$this->id_prefix = $this->get_field_id('');

		// Bg options
		$this->bg_options = array(
			'color' => true,
			'image' => true
		);

		// Admin Scripts
		add_action( 'admin_print_scripts-widgets.php', array( $this, 'admin_setup' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'render_control_template_scripts' ) );

		// Public scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'public_scripts') );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		$attr = array();
		$attr = apply_filters( 'image_widget_image_attributes', $attr, $instance );
		$bg_image_id = isset( $instance['bg_image_id'] ) ? $instance['bg_image_id'] : false;
		$bg_image = ( isset( $instance['bg_image'] ) && '' != $instance['bg_image'] ) ? $instance['bg_image'] : false;
		$bg_color = ( isset( $instance['bg_color'] ) && '' != $instance['bg_color'] ) ? $instance['bg_color'] : false;
		$category = ( isset( $instance['category'] ) ) ? $instance['category'] : 0;
		$num_columns = ( isset( $instance['num_columns'] ) ) ? $instance['num_columns'] : 1;
		$max_posts = ( isset( $instance['max_posts'] ) ) ? $instance['max_posts'] : 3;

		echo $args['before_widget'];
		?>

		<!-- BEGIN .organic-widgets-section -->
		<div class="organic-widgets-section organic-widgets-blog-posts-section" <?php if ( 0 < $bg_image_id ) { ?>style="background-image:url(<?php echo $bg_image; ?>);"<?php } elseif ($bg_color) { ?>style="background-color:<?php echo $bg_color; ?>;"<?php } ?>>

			<!-- BEGIN .organic-widgets-content -->
			<div class="organic-widgets-content">

			<?php if ( ! empty( $instance['title'] ) ) { ?>
				<h2 class="organic-widgets-title"><?php echo apply_filters( 'organic_widget_title', $instance['title'] ); ?></h2>
			<?php } ?>

			<?php if ( ! empty( $instance['text'] ) ) { ?>
				<div class="organic-widgets-text"><?php echo apply_filters( 'the_content', $instance['text'] ); ?></div>
			<?php } ?>

			<?php $wp_query = new WP_Query( array(
				'posts_per_page' => $max_posts,
				'post_type' => 'post',
				'suppress_filters' => 0,
				'cat' => $category,
			) ); ?>

			<?php if ( $wp_query->have_posts() ) : ?>

				<!-- BEGIN .organic-widgets-row -->
				<div class="organic-widgets-blog-posts-holder organic-widgets-post-holder organic-widgets-row organic-widgets-masonry-container">

					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

					<?php $thumb = ( '' != get_the_post_thumbnail() ) ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) : false; ?>

					<!-- BEGIN .organic-widgets-masonry-wrapper -->
					<div class="organic-widgets-masonry-wrapper organic-widgets-column organic-widgets-<?php echo $this->column_string( $num_columns ); ?>">

						<article>

							<?php if ( has_post_thumbnail() ) { ?>
								<a class="organic-widgets-featured-img" href="<?php the_permalink(); ?>" style="background-image: url(<?php echo esc_url( $thumb[0] ); ?>);">
									<span class="organic-widgets-hide-img"><?php the_post_thumbnail(); ?></span>
								</a>
							<?php } ?>

							<!-- BEGIN .organic-widgets-card -->
							<div class="organic-widgets-card clearfix">

								<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

								<!-- BEGIN .organic-widgets-post-meta -->
								<div class="organic-widgets-post-meta">
									<p class="organic-widgets-post-date">
										<?php echo get_the_modified_date(); ?>
									</p>
									<p class="organic-widgets-post-author">
										<?php esc_html_e( 'By ', ORGANIC_WIDGETS_18N ); ?><?php esc_url( the_author_posts_link() ); ?>
									</p>
								<!-- END .organic-widgets-post-meta -->
								</div>

								<?php the_excerpt(); ?>

								<?php edit_post_link( esc_html__( '(Edit)', ORGANIC_WIDGETS_18N ), '<p>', '</p>' ); ?>

							<!-- END .organic-widgets-card -->
							</div>

						</article>

					<!-- END .organic-widgets-masonry-wrapper -->
					</div>

					<?php endwhile; ?>

				<!-- END .organic-widgets-row -->
				</div>

			<?php endif; ?>

			<!-- END .organic-widgets-content -->
			</div>

		<!-- END .organic-widgets-section -->
		</div>

		<?php echo $args['after_widget'];

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	*/
	public function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title' => '',
				'text' => '',
			)
		);

		// Setup Variables.
		$this->id_prefix = $this->get_field_id('');
		if ( isset( $instance['category'] ) ) {
			$category = $instance['category'];
		} else { $category = 0; }
		if ( isset( $instance['num_columns'] ) ) {
			$num_columns = $instance['num_columns'];
		} else { $num_columns = 1; }
		if ( isset( $instance['max_posts'] ) ) {
			$max_posts = $instance['max_posts'];
		} else { $max_posts = 3; }
		if ( isset( $instance['bg_color'] ) ) {
			$bg_color = $instance['bg_color'];
		} else { $bg_color = false; }
		if ( isset( $instance['bg_image_id'] ) ) {
			$bg_image_id = $instance['bg_image_id'];
		} else { $bg_image_id = 0; }
		if ( isset( $instance['bg_image_id'] ) && isset( $instance['bg_image'] ) ) {
			$bg_image = $instance['bg_image'];
		} else { $bg_image = false; }

		?>

		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" class="title" type="hidden" value="<?php echo esc_attr( $instance['title'] ); ?>">
		<input id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" class="text organic-widgets-wysiwyg-anchor" type="hidden" value="<?php echo esc_attr( $instance['text'] ); ?>">
		<input id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>" class="filter" type="hidden" value="on">
		<input id="<?php echo $this->get_field_id( 'visual' ); ?>" name="<?php echo $this->get_field_name( 'visual' ); ?>" class="visual" type="hidden" value="on">

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e('Post Category:', ORGANIC_WIDGETS_18N) ?></label>
			<?php wp_dropdown_categories( array(
				'show_option_all' => __( 'All Categories' ),
				'selected' => $category,
				'id' => $this->get_field_id( 'category' ),
				'name' => $this->get_field_name( 'category' )
			)); ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'max_posts' ); ?>"><?php _e('Max Number of Posts:', ORGANIC_WIDGETS_18N) ?></label>
			<input type="number" min="1" max="16" value="<?php echo $max_posts; ?>" id="<?php echo $this->get_field_id('max_posts'); ?>" name="<?php echo $this->get_field_name('max_posts'); ?>" class="widefat" style="width:100%;"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_columns' ); ?>"><?php _e('Number of Columns:', ORGANIC_WIDGETS_18N) ?></label>
			<select id="<?php echo $this->get_field_id('num_columns'); ?>" name="<?php echo $this->get_field_name('num_columns'); ?>" class="widefat" style="width:100%;">
				<option <?php selected( $num_columns, '1'); ?> value="1">1</option>
				<option <?php selected( $num_columns, '2'); ?> value="2">2</option>
		    <option <?php selected( $num_columns, '3'); ?> value="3">3</option>
		    <option <?php selected( $num_columns, '4'); ?> value="4">4</option>
			</select>
		</p>

		<?php $this->section_background_input_markup( $instance, $this->bg_options ); ?>

  <?php
	}

	/**
	 * Render form template scripts.
	 *
	 *
	 * @access public
	 */
	public function render_control_template_scripts() {

		?>
		<script type="text/html" id="tmpl-widget-organic_widgets_blog_posts_section-control-fields">

			<# var elementIdPrefix = 'el' + String( Math.random() ).replace( /\D/g, '' ) + '_' #>

			<p>
				<label for="{{ elementIdPrefix }}title"><?php esc_html_e( 'Title:' ); ?></label>
				<input id="{{ elementIdPrefix }}title" type="text" class="widefat title">
			</p>
			<p>
				<label for="{{ elementIdPrefix }}text" class="screen-reader-text"><?php esc_html_e( 'Content:' ); ?></label>
				<textarea id="{{ elementIdPrefix }}text" class="widefat text wp-editor-area" style="height: 200px" rows="16" cols="20"></textarea>
			</p>
		</script>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		/*--- Text/Title ----*/
		if ( ! isset( $newinstance['filter'] ) )
			$instance['filter'] = false;
		if ( ! isset( $newinstance['visual'] ) )
			$instance['visual'] = null;
		// Upgrade 4.8.0 format.
		if ( isset( $old_instance['filter'] ) && 'content' === $old_instance['filter'] ) {
			$instance['visual'] = true;
		}
		if ( 'content' === $new_instance['filter'] ) {
			$instance['visual'] = true;
		}
		if ( isset( $new_instance['visual'] ) ) {
			$instance['visual'] = ! empty( $new_instance['visual'] );
		}
		// Filter is always true in visual mode.
		if ( ! empty( $instance['visual'] ) ) {
			$instance['filter'] = true;
		}
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['title'] = $new_instance['title'];
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['title'] = wp_kses_post( $new_instance['title'] );
			$instance['text'] = wp_kses_post( $new_instance['text'] );
		}
		/*--- END Text/Title ----*/

		if ( ! isset( $old_instance['created'] ) )
			$instance['created'] = time();
		if (isset( $new_instance['bg_image_id'] ) )
			$instance['bg_image_id'] = strip_tags( $new_instance['bg_image_id'] );
		if (isset( $new_instance['bg_image'] ) )
			$instance['bg_image'] = strip_tags( $new_instance['bg_image'] );
		if ( isset( $new_instance['bg_color'] ) && $this->check_hex_color( $new_instance['bg_color'] ) ) {
			$instance['bg_color'] = strip_tags( $new_instance['bg_color'] );
		} else {
			$instance['bg_color'] = false;
		}
		if ( isset( $new_instance['category'] ) )
			$instance['category'] = strip_tags( $new_instance['category'] );
		if ( isset( $new_instance['num_columns'] ) )
			$instance['num_columns'] = strip_tags( $new_instance['num_columns'] );
		if ( isset( $new_instance['max_posts'] ) )
			$instance['max_posts'] = strip_tags( $new_instance['max_posts'] );

		return $instance;
	}

	/**
	 * Enqueue admin javascript.
	 */
	public function admin_setup() {

		// Text Editor
		wp_enqueue_editor();
		wp_enqueue_script( 'organic-widgets-blog-posts-section-text-title', plugin_dir_url( __FILE__ ) . 'js/blog-posts-section-widgets.js', array( 'jquery' ) );
		wp_localize_script( 'organic-widgets-blog-posts-section-text-title', 'OrganicBlogPostsSectionWidget', array(
			'id_base' => $this->id_base,
		) );
		wp_add_inline_script( 'organic-widgets-blog-posts-section-text-title', 'wp.organicBlogPostsSectionWidget.init();', 'after' );

		wp_enqueue_media();

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_script( 'organic-widgets-module-color-picker', ORGANIC_WIDGETS_ADMIN_JS_DIR . 'organic-widgets-module-color-picker.js', array( 'jquery', 'media-upload', 'media-views', 'wp-color-picker' ) );

		wp_enqueue_script( 'organic-widgets-module-image-background', ORGANIC_WIDGETS_ADMIN_JS_DIR . 'organic-widgets-module-image-background.js', array( 'jquery', 'media-upload', 'media-views', 'wp-color-picker' ) );
		wp_localize_script( 'organic-widgets-module-image-background', 'OrganicWidgetBG', array(
			'frame_title' => __( 'Select an Image', ORGANIC_WIDGETS_18N ),
			'button_title' => __( 'Insert Into Widget', ORGANIC_WIDGETS_18N ),
		) );

	}

	/**
	 * Enqueue public javascript.
	 */
	public function public_scripts() {

		wp_enqueue_script( 'organic-widgets-masonry', ORGANIC_WIDGETS_BASE_DIR . 'public/js/masonry.js', array( 'jquery', 'media-upload', 'media-views', 'masonry' ) );
		wp_enqueue_script( 'blog-posts-section-widget-public-js', ORGANIC_WIDGETS_BASE_DIR . 'public/js/blog-posts-section.js', array( 'jquery', 'media-upload', 'media-views', 'masonry' ) );
		if ( ! wp_script_is('organic-widgets-backgroundimagebrightness-js') ) { wp_enqueue_script( 'organic-widgets-backgroundimagebrightness-js', ORGANIC_WIDGETS_BASE_DIR . 'public/js/jquery.backgroundbrightness.js', array( 'jquery' ) ); }

	}

} // class Organic_Widgets_Blog_Posts_Section_Widget

<?php
namespace lib\Widgets;
use WP_Widget;
/**
 * Custom Categories Widget
 * Sparkling Theme
 */
class CategoryListWidget extends WP_Widget {

	public static $lang = 'amorphous';

	function __construct() {

		$widget_ops = array(
			'classname' => 'code-catslist',
			'description' => esc_html__( 'Custom Categories' , self::$lang ),
		);
		  parent::__construct( 'custom-cat-list', esc_html__( 'Custom Cat List', self::$lang ), $widget_ops );
	}

	function widget( $args, $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Categories' , self::$lang );
		$enable_count = '';
		if ( isset( $instance['enable_count'] ) ) {
			$enable_count = $instance['enable_count'] ? $instance['enable_count'] : 'checked';
		}

		$limit = ($instance['limit']) ? $instance['limit'] : 4;

		echo $args['before_widget'];
		echo $args['before_title'];
		echo $title;
		echo $args['after_title'];

		/**
		 * Widget Content
		 */

		?>


	<div class="cats-widget">

		<ul><?php
		if ( '' != $enable_count ) {
			  $categories_args = array(
				  'echo' => 0,
				  'show_count' => 1,
				  'title_li' => '',
				  'depth' => 1,
				  'orderby' => 'count',
				  'order' => 'DESC',
				  'taxonomy' => 'code_category',
				  'number' => $limit,
			  );
		} else {
			$categories_args = array(
				'echo' => 0,
				'show_count' => 0,
				'title_li' => '',
				'depth' => 1,
				'orderby' => 'count',
				'order' => 'DESC',
				'taxonomy' => 'code_category',
				'number' => $limit,
			);
		}
		$variable = wp_list_categories( $categories_args );
		$variable = str_replace( '(' , '<span>(', $variable );
		$variable = str_replace( ')' , ')</span>', $variable );
		echo $variable; ?></ul>

	</div><!-- end widget content -->

		<?php

		echo $args['after_widget'];
	}


	function form( $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = esc_html__( 'Categories' , self::$lang );
		}
		if ( ! isset( $instance['limit'] ) ) {
			$instance['limit'] = 4;
		}
		if ( ! isset( $instance['enable_count'] ) ) {
			$instance['enable_count'] = '';
		}

		?>

	  <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title ', self::$lang ) ?></label>

		<input  type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"
				name="<?php echo $this->get_field_name( 'title' ); ?>"
				id="<?php $this->get_field_id( 'title' ); ?>"
				class="widefat" />
	  </p>

	  <p><label for="<?php echo $this->get_field_id( 'limit' ); ?>"> <?php esc_html_e( 'Limit Categories ', self::$lang ) ?></label>

		<input  type="text" value="<?php echo esc_attr( $instance['limit'] ); ?>"
				name="<?php echo $this->get_field_name( 'limit' ); ?>"
				id="<?php $this->get_field_id( 'limit' ); ?>"
				class="widefat" />
	  </p>

	  <p><label>
		<input  type="checkbox"
				name="<?php echo $this->get_field_name( 'enable_count' ); ?>"
				id="<?php $this->get_field_id( 'enable_count' ); ?>" <?php if ( '' != $instance['enable_count'] ) { echo 'checked=checked ';} ?>
		 />
			<?php esc_html_e( 'Enable Posts Count', self::$lang ) ?></label>
	   </p>

		<?php
	}
}

?>

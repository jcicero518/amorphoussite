<?php

namespace WPCustomWidgets;

use WP_Widget;

class RelatedLinksWidget extends WP_Widget {

	const WIDGET_ID = 'Related_Links_Widget';
	const WIDGET_NAME = 'Related Links Widget';

	public static $options = [
		'description' => 'Related Links'
	];

	/**
	 * Calls parent WP_Widget constructor with params for inclusion in Appearance > Widgets
	 * section of WP.
	 *
	 * RelatedLinksWidget constructor.
	 */
	public function __construct() {
		parent::__construct( self::WIDGET_ID, self::WIDGET_NAME, self::$options);
	}

	/**
	 * Gets unique ID string of the current instance (id_base-number)
	 *
	 * @return bool|string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Root ID for all widgets of this type.
	 *
	 * @return mixed|string
	 */
	public function getIdBase() {
		return $this->id_base;
	}

	/**
	 * Unique ID number of the current instance.
	 *
	 * @return bool|int
	 */
	public function getNumber() {
		return $this->number;
	}

	/**
	 * Check if link is external based on beginning of URL
	 *
	 * @param $url
	 * @return bool|int
	 */
	private function checkExternal( $url ) {
		return isset( $url ) ? preg_match( '/(http)s?/', $url ) : false;
	}

	/**
	 * Echoes widget content.
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
		$related_title = $instance['title'];
		$link_titles   = $instance['titles'];
		$link_urls     = $instance['urls'];
		$link_count    = count( $instance['titles'] );

		$link_is_ssl = isset( $_SERVER['HTTP_REFERER'] ) ? strpos( $_SERVER['HTTP_REFERER'], 'https' ) : false;

		if ( $link_is_ssl ) {
			$link_prefix = isset( $_SERVER['HTTP_HOST'] ) ? 'https://' . $_SERVER['HTTP_HOST'] . '/' : '/';
		} else {
			$link_prefix = isset( $_SERVER['HTTP_HOST'] ) ? 'http://' . $_SERVER['HTTP_HOST'] . '/' : '/';
		}

		$link_target = '';

		print $args['before_widget']
		      . $args['before_title']
		      . apply_filters( 'widget_title', $related_title )
		      . $args['after_title'];
		?>
		<div class="textwidget">
			<ul>
				<?php
				for ($i=0; $i<$link_count; $i++) {
					if ( $this->checkExternal( $link_urls[$i] ) ) {
						$link_prefix = '';
						$link_target = 'target="_blank" ';
					}
					?>
					<li>
						<a <?= $link_target; ?>
							title="<?= $link_titles[$i]; ?>"
							href="<?= $link_prefix . $link_urls[$i]; ?>">
							<?= $link_titles[$i]; ?>
						</a>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
		<?php

		print $args['after_widget'];
	}

	public function getTitleField( $instanceTitle ) {
		$format = '<p>';
		$format .= '<label for="%1$s">%2$s</label>';
		$format .= '<br />';
		$format .= '<input type="text" name="%3$s" id="%1$s" value="%4$s" class="widefat">';
		$format .= '</p>';

		printf( $format,
			$this->get_field_id( 'title' ),
			'Title',
			$this->get_field_name( 'title' ),
			$instanceTitle
		);
	}

	/**
	 * @param array $instance Current settings.
	 * @return void
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$title = esc_attr( $title );

		$field_instance_count = 0;

		print '<div class="wp-custom-widgets-related-wrapper">';

		$wId = $this->getId();
		$wIdBase = $this->getIdBase();
		$wNum = $this->getNumber();
		/*echo 'ID: ' . $wId . "<br />";
		echo 'Number: ' . $wNum . "<br />";
		echo 'ID Base: ' . $wIdBase;
		var_dump( $instance);*/

		?>

		<?php
		$this->getTitleField( $title );

		print '<p class="description">For external links, make sure they begin with <em>http://</em></p>';

		$fields = isset ( $instance['fields'] ) ? $instance['fields'] : array();
		$field_num = count( $fields );
		$fields[ $field_num + 1 ] = '';

		$titles = isset ( $instance['titles'] ) ? $instance['titles'] : array();
		$titles_num = count( $titles );
		$titles[ $titles_num + 1 ] = '';
		$titles_html = array();
		$titles_counter = 0;

		$urls = isset ( $instance['urls'] ) ? $instance['urls'] : array();
		$urls_num = count( $urls );
		$urls[ $urls_num + 1 ] = '';
		$urls_html = array();
		$urls_counter = 0;

		foreach ( $titles as $name => $value ) {
			$titles_html[] = sprintf(
				'<input type="text" name="%1$s[%2$s]" value="%3$s" class="widefat">',
				$this->get_field_name( 'titles' ),
				$titles_counter,
				esc_attr( $value )
			);
			$titles_counter += 1;
			$field_instance_count += 1;
		}

		foreach ( $urls as $name => $value ) {
			$urls_html[] = sprintf(
				'<input type="text" name="%1$s[%2$s]" value="%3$s" class="widefat">',
				$this->get_field_name( 'urls' ),
				$urls_counter,
				esc_attr( $value )
			);
			$urls_counter += 1;
		}

		?>
		<table border="0">
			<thead>
			<tr>
				<th>Link Title</th>
				<th>Link URL</th>
			</tr>
			</thead>
			<tbody>
			<?php
			for ( $i=0; $i<($field_instance_count + 1); $i++ ) {
				?>
				<tr>
					<td><?php echo $titles_html[$i]; ?></td>
					<td><?php echo $urls_html[$i]; ?></td>
				</tr>
				<?php
			}
			?>
			<tr colspan="2">
				<td class="button button-link button-add-row"><span title="Add row" class="fa fa-plus"></span> Add Row</td>
			</tr>
			</tbody>
		</table>
		<?php

		print '</div>'; // close out wrapper div
	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 * WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance           = $old_instance;
		$instance['title']  = esc_html( $new_instance['title'] );

		$instance['titles'] = array();
		$instance['urls']   = array();

		if ( isset ( $new_instance['titles'] ) ) {
			foreach ( $new_instance['titles'] as $value ) {
				if ( '' !== trim( $value ) )
					$instance['titles'][] = $value;
			}
		}

		if ( isset ( $new_instance['urls'] ) ) {
			foreach ( $new_instance['urls'] as $value ) {
				if ( '' !== trim( $value ) )
					$instance['urls'][] = $value;
			}
		}

		return $instance;
	}
}
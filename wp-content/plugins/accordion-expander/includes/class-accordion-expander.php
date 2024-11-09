<?php
if (!class_exists('AccordionExpander')):

	class AccordionExpander {
		/**
		 * Plugin name
		 */
		protected $plugin_name = 'AccordionExpander';
		/**
		 * Plugin slug
		 */
		protected $plugin_slug = 'accordion-expander';
		/**
		 * Plugin prefix
		 */
		protected $plugin_prefix = 'ACC';
		/**
		 * Current plugin version number
		 */
		private $plugin_version = '1.0.0';
		/**
		 * Accordion count
		 */
		private $accordion_item_count = 0;
		/**
		 * Plugin default options
		 */
		protected $default_options = array();

		public function __construct() {
			self::load_dependencies();
			self::set_options();
		}

		private function load_dependencies() {
			add_action('wp_enqueue_scripts', array(&$this, 'accordion_setup_scripts'));
			add_action('wp_enqueue_scripts', array(&$this, 'accordion_setup_styles'));
			add_shortcode('cgcc_accordion', array(&$this, 'accordion_short_render'));
		}

		private function set_options() {
			$this->default_options = array(
				'name'   => $this->plugin_name,
				'prefix' => $this->plugin_prefix
			);

			update_option($this->plugin_prefix, $this->default_options);
		}

		public function accordion_render_wrapper() {
			$accordionItemCount = $this->accordion_item_count;

			$wrapStart = '';
			$wrapStart .= '<div class="ucmm_accordion_instance" id="ucmm_accordion-' . $accordionItemCount . '" data-accord-num=' . $accordionItemCount . '">';
			$wrapEnd = '</div>';

			//$filterVal = apply_filters('equalizeContent', $wrapStart, 'equal1', 'equal2');
			//var_dump($filterVal);
			if (wp_script_is('accordion-expander', 'enqueued')) {
				//wp_localize_script( 'accordion-expander', 'AccExpander', $accordionItemCount );
				wp_localize_script('accordion-expander', 'AccExpander', array('defaults' => '0'));
			}

			$this->accordion_item_count++;

			return array(
				'wrapStart' => $wrapStart,
				'wrapEnd'   => $wrapEnd
			);

		}

		public function accordion_setup_scripts() {
			wp_register_script('gevent', '/wp-content/plugins/accordion-expander/js/jquery.gevent.js', array('jquery'), '', true);
			wp_register_script($this->plugin_slug, '/wp-content/plugins/accordion-expander/js/accordion-expander.js',
				array('jquery-ui-core', 'jquery-ui-accordion', 'gevent'),
				'',
				true
			);
			wp_enqueue_script('accordion-expander');
		}

		public function accordion_setup_styles() {
			wp_enqueue_style($this->plugin_slug, '/wp-content/plugins/accordion-expander/css/accordion-expander.css', array(), '', 'all');
		}

		public function accordion_short_render($atts, $content = NULL) {
			$output = '';

			// parse any parameters from shortcode, set defaults
			$args = shortcode_atts(array(
				'title'     => 'Default Title',
				'read_more' => true,
				'header'    => 'h3'
			), $atts);

			$args['read_more'] = false;
			$read_more_content = '<div><span class="ucmm_read_more"><a href> &raquo; Read more</a></span></div>';

			$wrapper = $this->accordion_render_wrapper();

			$output .= $wrapper['wrapStart'];

			$output .= '<h3>' . $args['title'];
			if ($args['read_more']) {
				$output .= $read_more_content;
			}
			$output .= '</h3>';

			$output .= '<div>' . $content . '</div>';

			$output .= $wrapper['wrapEnd'];

			//print '<pre>';var_dump($args);print '</pre>';
			return $output;
		}

	}

endif;

<?php

namespace lib\Sidebar;

class Widgets {

	public function __construct() {
		$this->widgetActions();
	}

	private function widgetActions() {
		add_action( 'categoryBrowser', function() {
			?>
			<div class="c-category-browser">
				<h3>Browse by Category</h3>
				<?php
				$args = [
					'option_none_value' => '0',
					'show_option_none' => 'Select Category',
					'class' => 'cat-dropdown',
					//'walker' => new lib\Render\WpCategoryDropdown(),
					'exclude' => [1], // uncategorized
					'value_field' => 'slug'
				];
				wp_dropdown_categories($args);

				?>
			</div>
		<?php
		});
	}
}
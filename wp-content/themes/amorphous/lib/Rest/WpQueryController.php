<?php

namespace lib\Rest;

class WpQueryController extends \WP_REST_Posts_Controller {

	public function __construct($post_type) {
		parent::__construct($post_type);
	}
}
<?php

namespace lib\Query;

use WP_Query;

/**
 * Class SiteQuery
 *
 * Extends base WP class WP_Query for custom post types
 *
 * @package lib\Query
 */
class SiteQuery extends WP_Query {


	/**
	 * SiteQuery constructor.
	 *
	 * Accepts parameters based on WP_Query
	 *
	 * @param array|string $query
	 */
	public function __construct( $query ) {
		$query = wp_parse_args( $query, [
			'post_type' => 'site'
		]);
		parent::__construct( $query );
	}

	public function getQuery() {
		return $this->query;
	}
}
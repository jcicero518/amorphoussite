<?php

namespace lib\CPT;

class Taxonomy {

	public function __construct() {
		foreach ( array_slice( get_class_methods( __CLASS__ ), 1 ) as $class_method ) {
			call_user_func( [ __CLASS__, $class_method ] );
		}
	}

	public function mwcc_tax_job_categories() {

		$labels = array(
			'name'                       => _x( 'Code Category', 'Taxonomy General Name', 'mwcc' ),
			'singular_name'              => _x( 'Code Category', 'Taxonomy Singular Name', 'mwcc' ),
			'menu_name'                  => __( 'Code Category', 'mwcc' ),
			'all_items'                  => __( 'All Code Categories', 'mwcc' ),
			'parent_item'                => __( 'Parent Code Category', 'mwcc' ),
			'parent_item_colon'          => __( 'Parent Code Category:', 'mwcc' ),
			'new_item_name'              => __( 'New Code Category', 'mwcc' ),
			'add_new_item'               => __( 'Add New Code Category', 'mwcc' ),
			'edit_item'                  => __( 'Edit Code Category', 'mwcc' ),
			'update_item'                => __( 'Update Code Category', 'mwcc' ),
			'view_item'                  => __( 'View Code Category', 'mwcc' ),
			'separate_items_with_commas' => __( 'Separate Code Categories with commas', 'mwcc' ),
			'add_or_remove_items'        => __( 'Add or remove Code Categories', 'mwcc' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'mwcc' ),
			'popular_items'              => __( 'Popular Code Categoies', 'mwcc' ),
			'search_items'               => __( 'Search Code Categories', 'mwcc' ),
			'not_found'                  => __( 'Not Found', 'mwcc' ),
			'no_terms'                   => __( 'No Code Categories', 'mwcc' ),
			'items_list'                 => __( 'Code Category list', 'mwcc' ),
			'items_list_navigation'      => __( 'Code Category list navigation', 'mwcc' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			//'show_ui'                    => false,
			'show_in_quick_edit'         => true,
			//'meta_box_cb'                => false,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
			'show_in_rest'               => true,
		);
		register_taxonomy( 'code_category', array( 'code' ), $args );
	}

	public function mwcc_tax_site_categories() {

		$labels = array(
			'name'                       => _x( 'Site Category', 'Taxonomy General Name', 'mwcc' ),
			'singular_name'              => _x( 'Site Category', 'Taxonomy Singular Name', 'mwcc' ),
			'menu_name'                  => __( 'Site Category', 'mwcc' ),
			'all_items'                  => __( 'All Site Categories', 'mwcc' ),
			'parent_item'                => __( 'Parent Site Category', 'mwcc' ),
			'parent_item_colon'          => __( 'Parent Site Category:', 'mwcc' ),
			'new_item_name'              => __( 'New Site Category', 'mwcc' ),
			'add_new_item'               => __( 'Add New Site Category', 'mwcc' ),
			'edit_item'                  => __( 'Edit Site Category', 'mwcc' ),
			'update_item'                => __( 'Update Site Category', 'mwcc' ),
			'view_item'                  => __( 'View Site Category', 'mwcc' ),
			'separate_items_with_commas' => __( 'Separate Site Categories with commas', 'mwcc' ),
			'add_or_remove_items'        => __( 'Add or remove Site Categories', 'mwcc' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'mwcc' ),
			'popular_items'              => __( 'Popular Site Categoies', 'mwcc' ),
			'search_items'               => __( 'Search Site Categories', 'mwcc' ),
			'not_found'                  => __( 'Not Found', 'mwcc' ),
			'no_terms'                   => __( 'No Site Categories', 'mwcc' ),
			'items_list'                 => __( 'Site Category list', 'mwcc' ),
			'items_list_navigation'      => __( 'Site Category list navigation', 'mwcc' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			//'show_ui'                    => false,
			'show_in_quick_edit'         => true,
			//'meta_box_cb'                => false,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
			'show_in_rest'               => true,
		);
		register_taxonomy( 'site_category', array( 'site' ), $args );
	}
}
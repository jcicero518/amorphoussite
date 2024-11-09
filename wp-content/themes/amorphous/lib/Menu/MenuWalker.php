<?php

namespace lib\Menu;

class MenuWalker extends \Walker_Nav_Menu {

	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

		$object      = $item->object;
		$objectId    = $item->object_id; // page ID
		$type        = $item->type;
		$title       = $item->title;
		$description = $item->description;
		$classes     = $item->classes;
		$permalink   = $item->url;

		$item->classes = array_merge( $classes, ['menu-item', 'menu-page-id-' . $objectId ] );
		$item->linkClasses = ['navbar-item'];

		$output .= "<li class='" . trim( implode(" ", $item->classes) ) . "'>";

		//Add SPAN if no Permalink
		if ($permalink && $permalink != '#') {
			$output .= '<a class="' . implode(" ", $item->linkClasses) . '" href="' . $permalink . '">';
		} else {
			$output .= '<span>';
		}

		$output .= $title;
		if ($description != '' && $depth == 0) {
			$output .= '<small class="description">' . $description . '</small>';
		}
		if ($permalink && $permalink != '#') {
			$output .= '</a>';
		} else {
			$output .= '</span>';
		}
	}

}
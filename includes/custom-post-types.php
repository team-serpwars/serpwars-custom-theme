<?php 
function cptui_register_my_cpts_services() {

	/**
	 * Post Type: Services.
	 */

	$labels = [
		"name" => __( "Services", "hello-elementor-child" ),
		"singular_name" => __( "Service", "hello-elementor-child" ),
	];

	$args = [
		"label" => __( "Services", "hello-elementor-child" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "services", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-tag",
		"supports" => [ "title", "editor", "thumbnail", "custom-fields", "page-attributes" ],
	];

	register_post_type( "services", $args );
}

add_action( 'init', 'cptui_register_my_cpts_services' );

function cptui_register_my_cpts_locations() {

	/**
	 * Post Type: Locations.
	 */

	$labels = [
		"name" => __( "Locations", "hello-elementor-child" ),
		"singular_name" => __( "Location", "hello-elementor-child" ),
		"menu_name" => __( "Locations", "hello-elementor-child" ),
		"all_items" => __( "All Locations", "hello-elementor-child" ),
	];

	$args = [
		"label" => __( "Locations", "hello-elementor-child" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "locations", "with_front" => false ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "custom-fields", "revisions", "author", "page-attributes", "post-formats" ],
		"taxonomies" => [ "post_tag" ],
	];

	register_post_type( "locations", $args );
}

add_action( 'init', 'cptui_register_my_cpts_locations' );


?>
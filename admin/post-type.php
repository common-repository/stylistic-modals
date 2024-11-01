<?php
if (!function_exists('drsm_create_stylisticmodal_cpt')) {
	// Register Custom Post Type Stylistic Modal
	function drsm_create_stylisticmodal_cpt() {

		$labels = array(
			'name' => _x( 'Stylistic Modals', 'Post Type General Name', 'stylisticmodals' ),
			'singular_name' => _x( 'Stylistic Modal', 'Post Type Singular Name', 'stylisticmodals' ),
			'menu_name' => _x( 'Stylistic Modals', 'Admin Menu text', 'stylisticmodals' ),
			'name_admin_bar' => _x( 'Stylistic Modal', 'Add New on Toolbar', 'stylisticmodals' ),
			'archives' => __( 'Stylistic Modal Archives', 'stylisticmodals' ),
			'attributes' => __( 'Stylistic Modal Attributes', 'stylisticmodals' ),
			'parent_item_colon' => __( 'Parent Stylistic Modal:', 'stylisticmodals' ),
			'all_items' => __( 'All Stylistic Modals', 'stylisticmodals' ),
			'add_new_item' => __( 'Add New Stylistic Modal', 'stylisticmodals' ),
			'add_new' => __( 'Add New', 'stylisticmodals' ),
			'new_item' => __( 'New Stylistic Modal', 'stylisticmodals' ),
			'edit_item' => __( 'Edit Stylistic Modal', 'stylisticmodals' ),
			'update_item' => __( 'Update Stylistic Modal', 'stylisticmodals' ),
			'view_item' => __( 'View Stylistic Modal', 'stylisticmodals' ),
			'view_items' => __( 'View Stylistic Modals', 'stylisticmodals' ),
			'search_items' => __( 'Search Stylistic Modal', 'stylisticmodals' ),
			'not_found' => __( 'Not found', 'stylisticmodals' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'stylisticmodals' ),
			'featured_image' => __( 'Featured Image', 'stylisticmodals' ),
			'set_featured_image' => __( 'Set featured image', 'stylisticmodals' ),
			'remove_featured_image' => __( 'Remove featured image', 'stylisticmodals' ),
			'use_featured_image' => __( 'Use as featured image', 'stylisticmodals' ),
			'insert_into_item' => __( 'Insert into Stylistic Modal', 'stylisticmodals' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Stylistic Modal', 'stylisticmodals' ),
			'items_list' => __( 'Stylistic Modals list', 'stylisticmodals' ),
			'items_list_navigation' => __( 'Stylistic Modals list navigation', 'stylisticmodals' ),
			'filter_items_list' => __( 'Filter Stylistic Modals list', 'stylisticmodals' ),
		);
		$args = array(
			'label' => __( 'Stylistic Modal', 'stylisticmodals' ),
			'description' => __( '', 'stylisticmodals' ),
			'labels' => $labels,
			'menu_icon' => 'dashicons-megaphone',
			'supports' => array(),
			'taxonomies' => array(),
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 5,
			'show_in_admin_bar' => true,
			'show_in_nav_menus' => true,
			'can_export' => true,
			'has_archive' => true,
			'hierarchical' => false,
			'exclude_from_search' => false,
			'show_in_rest' => true,
			'publicly_queryable' => true,
			'capability_type' => 'post',
		);
		register_post_type( 'stylisticmodal', $args );
	}
}
add_action( 'init', 'drsm_create_stylisticmodal_cpt', 0 );

<?php

// Register Custom Post Type
function prayer_post_type() {

	$labels = array(
		'name'                => _x( 'Prayers', 'Post Type General Name', 'prayer' ),
		'singular_name'       => _x( 'Prayer', 'Post Type Singular Name', 'prayer' ),
		'menu_name'           => __( 'Prayers', 'prayer' ),
		'parent_item_colon'   => __( 'Parent Prayer:', 'prayer' ),
		'all_items'           => __( 'All Prayers', 'prayer' ),
		'view_item'           => __( 'View Prayer', 'prayer' ),
		'add_new_item'        => __( 'Add New Prayer', 'prayer' ),
		'add_new'             => __( 'Add New', 'prayer' ),
		'edit_item'           => __( 'Edit Prayer', 'prayer' ),
		'update_item'         => __( 'Update Prayer', 'prayer' ),
		'search_items'        => __( 'Search Prayer', 'prayer' ),
		'not_found'           => __( 'Not found', 'prayer' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'prayer' ),
	);
	$rewrite = array(
		'slug'                => 'prayers',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __( 'prayer', 'prayer' ),
		'description'         => __( 'Prayer Requests', 'prayer' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
		'taxonomies'          => array( 'prayer_category', 'prayer_tag', 'prayer_location' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 24,
		'menu_icon'           => 'dashicons-heart',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'post',
		'register_meta_box_cb' => 'add_prayer_metaboxes'
	);
	register_post_type( 'prayer', $args );

}
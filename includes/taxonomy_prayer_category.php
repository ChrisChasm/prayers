<?php

// Register Custom Taxonomy
function prayer_category_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'prayer' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'prayer' ),
		'menu_name'                  => __( 'Categories', 'prayer' ),
		'all_items'                  => __( 'All Categories', 'prayer' ),
		'parent_item'                => __( 'Parent Category', 'prayer' ),
		'parent_item_colon'          => __( 'Parent Category:', 'prayer' ),
		'new_item_name'              => __( 'New Category', 'prayer' ),
		'add_new_item'               => __( 'Add New Category', 'prayer' ),
		'edit_item'                  => __( 'Edit Category', 'prayer' ),
		'update_item'                => __( 'Update Category', 'prayer' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'prayer' ),
		'search_items'               => __( 'Search Categories', 'prayer' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'prayer' ),
		'choose_from_most_used'      => __( 'Choose from the most used categories', 'prayer' ),
		'not_found'                  => __( 'Not Found', 'prayer' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		//'update_count_callback'      => 'prayer_category_count_cb',	
	);
	register_taxonomy( 'prayer_category', array( 'prayer' ), $args );

}
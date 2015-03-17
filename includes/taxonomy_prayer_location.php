<?php

// Register Custom Taxonomy
function prayer_location_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Locations', 'Taxonomy General Name', 'prayer' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'prayer' ),
		'menu_name'                  => __( 'Locations', 'prayer' ),
		'all_items'                  => __( 'All Locations', 'prayer' ),
		'parent_item'                => __( 'Parent Location', 'prayer' ),
		'parent_item_colon'          => __( 'Parent Location:', 'prayer' ),
		'new_item_name'              => __( 'New Location', 'prayer' ),
		'add_new_item'               => __( 'Add New Location', 'prayer' ),
		'edit_item'                  => __( 'Edit Location', 'prayer' ),
		'update_item'                => __( 'Update Location', 'prayer' ),
		'separate_items_with_commas' => __( 'Separate Locations with commas', 'prayer' ),
		'search_items'               => __( 'Search Locations', 'prayer' ),
		'add_or_remove_items'        => __( 'Add or remove locations', 'prayer' ),
		'choose_from_most_used'      => __( 'Choose from the most used locations', 'prayer' ),
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
		'update_count_callback'      => 'prayer_location_count_cb',	);
	register_taxonomy( 'prayer_location', array( 'prayer' ), $args );

}
<?php

/**
 * Taxonomy List
 * 
 * Get Custom Prayer Taxonomies and output lists
 */
function get_echo_terms_list( $id = 0, $taxonomy = null ) {
	if ( is_null($taxonomy) ) { return 'Taxonomy not supplied'; }

	// get the categories for custom post type
	$categories = get_the_terms( $id, $taxonomy );

	// return a wrapped list
	if ( $categories && ! is_wp_error( $categories ) ) {

		$output = '<span class="echo echo-box category taxonomy-' . $taxonomy . '">';

		$categories_list = array();
		foreach ( $categories as $term ) {
			$categories_list[] = $term->name;
		} 
		$categories_output_list = join( ", ", $categories_list);
		$output .= $categories_output_list;
		$output .= '</span>';
	}

	return $output;
}

/**
 * Prayer Click Button
 *
 * Lets anonymous users record that they've prayed for this request
 */
function get_echo_prayed_button() {
	?>
		<span class="echo-pray-button" data-prayer-click="<?php the_ID(); ?>"><a href="#">I Prayed</a></span>
	<?php
}

// Get prayer location
function get_echo_prayer_location( $id = 0 ) {
	if ( $id == 0) { return; }

	$prayer_location = get_post_meta( $id, 'meta-prayer-location', 1);
	if ( empty($prayer_location) ) { return; }

	?><span class="echo-box"><?php echo $prayer_location; ?></span><?
}

// Get prayer name
function get_echo_prayer_name( $id = 0 ) {
	if ( $id == 0) { return; }

	$prayer_name = get_post_meta( $id, 'meta-prayer-name', 1);
	if ( empty($prayer_name) ) { return; }

	?><span class="echo-prayer-name"><?php echo $prayer_name; ?></span><?
}
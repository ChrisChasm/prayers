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

		$output = '<span class="echo category taxonomy-' . $taxonomy . '">';

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
		<li class="echo prayer-click" data-prayer-click="<?php the_ID(); ?>">
			<span><a href="#">I Prayed</a></span>
		</li>
	<?php
}
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
function get_echo_prayed_button( $id = 0 ) {

	$prayer_count = get_post_meta( $id, 'meta-prayer-count', 1);

	if ( empty($prayer_count) ) {
		$prayer_count = 0;
	}

	?>
		<div class="echo-prayer-button" data-prayer-id="<?php the_ID(); ?>">
			<span class="echo-prayer-count"><?php echo $prayer_count; ?></span>
			<span class="echo-pray-button" data-prayer-click="<?php the_ID(); ?>"><a href="/">Pray</a></span>
		</div>

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

// Get Prayer Count
function get_echo_prayer_count( $id = 0 ) {
	if ($id == 0) return 0;

	$prayer_count = get_post_meta( $id, 'meta-prayer-count', 1);

	if ( empty($prayer_count) ) {
		$prayer_count = 0;
	}

	if ($prayer_count == 1) {
		$output = __("Prayed once", "echo");
	}
	else {
		$output = __("Prayed", "echo") . " " . $prayer_count . " " . __("times", "echo");		
	}

	return $output;
}
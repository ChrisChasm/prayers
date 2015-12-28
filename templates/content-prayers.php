<?php

	// WP_Query arguments
	$args = array (
		'post_type'              => array( 'prayer' ),
		'post_status'            => array( 'publish' ),
		'meta_query' => array(
			array(
				'key' => 'meta-prayer-anonymous',
				'value' => true,
				'compare' => 'NOT LIKE',
			),
		),
	);

	// The Query
	$query = new WP_Query( $args );

	// The Loop
	if ( $query->have_posts() ) {
		echo '<ul>';
		while ( $query->have_posts() ) {
			$query->the_post();

			// Get custom metadata

			echo '<li>';
			echo '<h3 class="prayer-title">' . get_the_title() . '</h3>';
			echo '<div class="prayer-content">' . get_the_content() . '</div>';
			echo '</li>';
		}
		echo '</ul>';
	} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata(); ?>
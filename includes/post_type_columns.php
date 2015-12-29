<?php


function echo_prayers_columns_head( $columns ) {

	unset($columns['author']);

	$date = $columns['date'];
	unset($columns['date']);

	$category = $columns['taxonomy-prayer_category'];
	unset($columns['taxonomy-prayer_category']);

	$columns['prayer_submitter'] = __( 'Submitter', 'echo' );
	$columns['prayer_location'] = __( 'Location', 'echo' );
	$columns['prayer_coordinates'] = __( 'Coordinates', 'echo' );
	$columns['prayer_count'] = __( 'Prayed', 'echo' );

	$columns['taxonomy-prayer_category'] = $category;
	$columns['date'] = $date;

	return $columns;
}
function echo_prayers_columns( $column_name, $post_ID ) {
	$post_meta = get_post_meta( $post_ID );

	if ($column_name == 'prayer_count' ) {
		$prayer_count = $post_meta['meta-prayer-count'][0];
		echo $prayer_count;
	}
	if ($column_name == 'prayer_location' ) {
		$prayer_location = $post_meta['meta-prayer-location'][0];
		$prayer_country = $post_meta['meta-prayer-location-country-long'][0];
		echo $prayer_location . "<br />" . $prayer_country;
	}
	if ($column_name == 'prayer_submitter' ) {
		$prayer_name = $post_meta['meta-prayer-name'][0];
		$prayer_email = $post_meta['meta-prayer-email'][0];
		?>
			<div class="echo-admin echo-submitter">
				<div class="avatar">
					<?php echo get_avatar( $prayer_email, 26 ); ?>
				</div>
				<div class="details">
					<?php echo $prayer_name; ?>
				</div>
			<div>
		<?php
	}
	if ($column_name == 'prayer_coordinates') {
		$lat = $post_meta['meta-prayer-location-latitude'][0];
		$long = $post_meta['meta-prayer-location-longitude'][0];

		if ( ! empty($lat) && ! empty($long) ) {
			echo $lat . "<br />" . $long . "<br />";
			echo '<div class="row-actions">';
			echo '<a href="http://maps.google.com/?ie=UTF8&hq=&ll=' . $lat . ',' . $long . '&z=13" target="_blank">Map</a>';
			echo '</div>';			
		}

	}
}
add_filter( 'manage_prayer_posts_columns', 'echo_prayers_columns_head' );
add_action( 'manage_prayer_posts_custom_column', 'echo_prayers_columns', 10, 2 );
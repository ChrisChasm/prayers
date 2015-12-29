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
	if ($column_name == 'prayer_count' ) {
		$prayer_count = get_post_meta( $post_ID, 'meta-prayer-count',  1 );
		echo $prayer_count;
	}
	if ($column_name == 'prayer_location' ) {
		$prayer_location = get_post_meta( $post_ID, 'meta-prayer-location',  1 );
		$prayer_country = get_post_meta( $post_ID, 'meta-prayer-location-country-long', 1);
		echo $prayer_location . "<br />" . $prayer_country;
	}
	if ($column_name == 'prayer_submitter' ) {
		$prayer_name = get_post_meta( $post_ID, 'meta-prayer-name',  1 );
		$prayer_email = get_post_meta( $post_ID, 'meta-prayer-email',  1 );
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
		$lat = get_post_meta( $post_ID, 'meta-prayer-location-latitude', 1);
		$long = get_post_meta( $post_ID, 'meta-prayer-location-longitude', 1);

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
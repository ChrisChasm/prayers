<?php


function echo_prayers_columns_head( $defaults ) {
	$defaults['prayer_count'] = __( 'Prayed', 'echo' );
	$defaults['prayer_location'] = __( 'Location', 'echo' );
	$defaults['prayer_coordinates'] = __( 'Coordinates', 'echo' );
	$defaults['prayer_submitter'] = __( 'Submitter', 'echo' );
	return $defaults;
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
add_filter( 'manage_posts_columns', 'echo_prayers_columns_head' );
add_action( 'manage_posts_custom_column', 'echo_prayers_columns', 10, 2 );
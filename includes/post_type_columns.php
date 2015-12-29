<?php


function echo_prayers_columns_head( $columns ) {

	unset($columns['author']);

	$date = $columns['date'];
	unset($columns['date']);

	$category = $columns['taxonomy-prayer_category'];
	unset($columns['taxonomy-prayer_category']);

	$columns['prayer_location'] = __( 'Location', 'echo' );
	$columns['taxonomy-prayer_category'] = $category;
	$columns['prayer_count'] = __( 'Prayed', 'echo' );
	$columns['prayer_answered'] = __( 'Answered?', 'echo' );
	$columns['prayer_anonymous'] = __( 'Anonymous?', 'echo' );

	$columns['date'] = $date;

	return $columns;
}
function echo_prayers_columns( $column_name, $post_ID ) {
	$post_meta = get_post_meta( $post_ID );

	// geocoded info
	$lat = $post_meta['meta-prayer-location-latitude'][0];
	$long = $post_meta['meta-prayer-location-longitude'][0];

	if ($column_name == 'prayer_count' ) {
		$prayer_count = $post_meta['meta-prayer-count'][0];
		echo $prayer_count;
	}
	if ($column_name == 'prayer_location' ) {
		
		$prayer_name = $post_meta['meta-prayer-name'][0];
		$prayer_email = $post_meta['meta-prayer-email'][0];
		$prayer_location = $post_meta['meta-prayer-location'][0];
		$prayer_country = $post_meta['meta-prayer-location-country-long'][0];

		?>
			<div class="echo-admin echo-location">
				<div class="avatar">
					<?php echo get_avatar( $prayer_email, 26 ); ?>
				</div>
				<div class="details">
					<?php echo $prayer_name; ?><br />
					<?php if ( ! empty($lat) && ! empty($long) ): ?>
					<?php echo $prayer_location . " (" . $prayer_country . ")"; ?><br />
					Coord: <?php echo '<a href="http://maps.google.com/?ie=UTF8&hq=&ll=' . $lat . ',' . $long . '&z=13" target="_blank">' . $lat . ' / ' . $long . '</a>'; ?>
					<?php endif; ?>
				</div>
			<div>
		<?php

	}
	if ($column_name == 'prayer_submitter' ) {
		
	}
	if ($column_name == 'prayer_answered') {
		$answered = $post_meta['meta-prayer-answered'][0];
		
		if ($answered) {
			echo "Yes";
		}
		else {
			echo "No";
		}
	}
	if ($column_name == 'prayer_anonymous') {
		$anonymous = $post_meta['meta-prayer-anonymous'][0];
		
		if ($anonymous) {
			echo "Yes";
		}
		else {
			echo "No";
		}
	}
}
add_filter( 'manage_prayer_posts_columns', 'echo_prayers_columns_head' );
add_action( 'manage_prayer_posts_custom_column', 'echo_prayers_columns', 10, 2 );
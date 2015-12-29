<?php


function echo_prayers_columns_head( $defaults ) {
	$defaults['prayer_count'] = __( 'Prayed', 'echo' );
	$defaults['prayer_location'] = __( 'Location', 'echo' );
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
		echo $prayer_location;
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
}
add_filter( 'manage_posts_columns', 'echo_prayers_columns_head' );
add_action( 'manage_posts_custom_column', 'echo_prayers_columns', 10, 2 );
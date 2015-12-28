<?php

function add_prayer_metaboxes() {
	add_meta_box('prayer_answered', 
		__('Prayer Meta', 'prayer'), 'prayer_answered_cb', 'prayer', 'side', 'high');
}

add_action( 'add_meta_boxes', 'add_prayer_metaboxes', 0 );

function prayer_answered_cb( $post ) {
    // Noncename needed to verify where the data originated
	wp_nonce_field( basename(__FILE__), 'prayer_nonce' );
	$prayer_stored_meta = get_post_meta( $post->ID );

	// answered value
	$answered = $prayer_stored_meta['meta-prayer-answered'][0];
	if (empty($answered)) {
		$answered = 'no';
	}
	$answeredTrue = $answered == 'yes' ? 'checked' : '';
	$answeredFalse = $answered == 'no' ? 'checked' : '';

	?>
	<p>
		<label for="meta-prayer-answered"><?php echo __('Answered?', 'prayer') ?> </label>
		<label><input type="radio" name="meta-prayer-answered" value="no" <?php echo $answeredFalse; ?> /><span>No </span></label>
		<label><input type="radio" name="meta-prayer-answered" value="yes" <?php echo $answeredTrue; ?> /><span>Yes </span></label>
	</p><?php

	// answered value
	$anonymous = $prayer_stored_meta['meta-prayer-anonymous'][0];
	if (empty($anonymous)) {
		$anonymous = 'no';
	}
	$anonymousTrue = $anonymous == 'yes' ? 'checked' : '';
	$anonymousFalse = $anonymous == 'no' ? 'checked' : '';

	?>
	<p>
		<label for="meta-prayer-anonymous"><?php echo __('Anonymous?', 'prayer') ?></label>
		<label><input type="radio" name="meta-prayer-anonymous" value="no" <?php echo $anonymousFalse; ?> /><span>No </span></label>
		<label><input type="radio" name="meta-prayer-anonymous" value="yes" <?php echo $anonymousTrue; ?> /><span>Yes </span></label>
	</p>

	<?php
	$location = $prayer_stored_meta['meta-prayer-location'][0];
	?>

	<p>
		<label for="meta-prayer-location"><?php echo __('Location', 'prayer') ?></label>
		<input type="text" name="meta-prayer-location" value="<?php echo $location; ?>" />
	</p>
	<?php
    
}

// save the custom meta input
function prayer_meta_save( $post_id ) {

	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prayer_nonce' ] ) && wp_verify_nonce( $_POST[ 'prayer_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'meta-prayer-answered' ] ) ) {
        update_post_meta( $post_id, 'meta-prayer-answered', sanitize_text_field( $_POST[ 'meta-prayer-answered' ] ) );
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'meta-prayer-anonymous' ] ) ) {
        update_post_meta( $post_id, 'meta-prayer-anonymous', sanitize_text_field( $_POST[ 'meta-prayer-anonymous' ] ) );
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'meta-prayer-location' ] ) ) {
    	update_post_meta( $post_id, 'meta-prayer-location', sanitize_text_field( $_POST[ 'meta-prayer-location' ] ) );
    }

}
add_action( 'save_post', 'prayer_meta_save' );
<?php
/**
 * Form Processing
 *
 * Povides form processing functions for frontend submissions, prayer clicks,
 * etc. 
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

/**
 * Prayer Form Processor
 *
 * Processes frontend prayer form submissions based on the [prayers_form]
 * shortcode. Checks against a nonce to prevent cross site hacking. 
 *
 * @since  0.9.0
 */
function echo_prayer_form_submission() {
	// check to see if this is a prayer submission
	if ( isset( $_POST['prayer-submission']) && '1' == $_POST['prayer-submission']) {
		// check for a valid nonce
		$is_valid_nonce = ( isset( $_POST[ 'prayer_nonce' ] ) && wp_verify_nonce( $_POST[ 'prayer_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false'; 
	    // Exits script depending on save status
	    if ( ! $is_valid_nonce ) {
	        return;
	    }
	    // get the post
		$post = $_POST;
		// check to make sure the taxonomy term exists
		$prayer_category = term_exists( $post['prayer_category'], 'prayer_category', 0 );
		// insert the term if it does not
		if ( ! $prayer_category ) {
			$prayer_category = wp_insert_term( $prayer_category, 'prayer_category', array( 'parent' => 0 ) );
		}
		// build a prayer entry to be insterted into the db
		$prayer = array(
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_author' => 0,
			'post_title' => $post['prayer_title'],
			'post_content' => $post['prayer_content'],
			'post_status' => 'pending',
			'post_type' => 'prayer',
			'tax_input' => [ 'prayer_category' => $prayer_category['term_taxonomy_id'], 'prayer_location' => $prayer_location['term_taxonomy_id'] ],
		);
		// create the pending prayer request
		$prayer_id = wp_insert_post($prayer);
		// add meta to the prayer after insert. You have to get a post id
		// before being able to insert meta.
		add_post_meta( $prayer_id, 'meta-prayer-anonymous', $post['prayer_anonymous'] );
		add_post_meta( $prayer_id, 'meta-prayer-answered', 0);
		add_post_meta( $prayer_id, 'meta-prayer-count', 0);
		add_post_meta( $prayer_id, 'meta-prayer-name', $post['prayer_name'] );
		add_post_meta( $prayer_id, 'meta-prayer-email', $post['prayer_email'] );
		add_post_meta( $prayer_id, 'meta-prayer-location', $post['prayer_location'] );
		// calculate coordinates and store them 
		$location = echo_parse_location($post['prayer_location']);
		echo_save_location_meta( $prayer_id, $location );
	}
}

/**
 * Prayer Click Submission
 *
 * Process prayer click submissions by incremting the prayer count for
 * individual prayer posts.
 *
 * @since 0.9.0 
 */
function echo_prayed_click_submit() {
	// check to see if this is a prayer click submission
	if ( isset( $_POST['prayer-click']) && '1' == $_POST['prayer-click']) {
		// check for a valid nonce
		$is_valid_nonce = ( isset( $_POST[ 'prayer_nonce' ] ) && wp_verify_nonce( $_POST[ 'prayer_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false'; 
	    // Exits script depending on save status
	    if ( !$is_valid_nonce ) {
	        return;
	    }
	    // get the post data to work with
		$post = $_POST;
		// get the current prayer count or set to 0 if it's empty
		$count = get_post_meta( $post['prayer_id'], 'meta-prayer-count', 1 );
		if ( empty($count) ) {
			$count = 0;
		}
		// increase the count by 1
		$count++;
		// update the prayer count
		update_post_meta( $post['prayer_id'], 'meta-prayer-count', $count );
	}
}
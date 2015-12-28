<?php

/**
* Plugin Name: Echo
* Plugin URI: http://github.com/kalebheitzman/echo
* Description: Lets an organization share and update prayer requests via their website. This plugin also provides JSON feeds for other services to consume.
* Version: 1.0
* Author: Kaleb Heitzman
* Author URI: http://github.com/kalebheitzman/echo
* License: MIT
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// load template loader
require plugin_dir_path( __FILE__ ) . 'includes/template-loader.php';

// load prayer post type
require plugin_dir_path( __FILE__ ) . 'includes/post_type_prayer.php';
// Hook into the 'init' action
add_action( 'init', 'prayer_post_type', 0 );

// add post type menu
require plugin_dir_path( __FILE__ ) . 'includes/post_type_menu.php';
add_action('admin_menu' , 'prayer_feeds_menu', 0 );
add_action('admin_menu' , 'prayer_settings_menu', 0 );

// load prayer taxonomies
require plugin_dir_path( __FILE__ ) . 'includes/taxonomy_prayer_category.php';
require plugin_dir_path( __FILE__ ) . 'includes/taxonomy_prayer_location.php';
require plugin_dir_path( __FILE__ ) . 'includes/taxonomy_prayer_post_tag.php';
// Hook into the 'init' action
add_action( 'init', 'prayer_category_taxonomy', 1 );
// Hook into the 'init' action
add_action( 'init', 'prayer_location_taxonomy', 2 );
// Hook into the 'init' action
add_action( 'init', 'prayer_post_tag_taxonomy', 3 );

// load shortcodes
require plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';
// register the shortcodes
add_shortcode( 'prayers', 'prayers_shortcode' );

require plugin_dir_path( __FILE__ ) . 'includes/post_type_meta.php';

// prayer form submission
function prayer_submission() {

	if ( isset( $_POST['prayer-submission']) && '1' == $_POST['prayer-submission']) {
		// check for a valid nonce
		$is_valid_nonce = ( isset( $_POST[ 'prayer_nonce' ] ) && wp_verify_nonce( $_POST[ 'prayer_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false'; 
	    // Exits script depending on save status
	    if ( !$is_valid_nonce ) {
	        return;
	    }

		$post = $_POST;

		$prayer = array(
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_author' => 0,
			'post_title' => $post['prayer_title'],
			'post_content' => $post['prayer_content'],
			'post_status' => 'pending',
			'post_type' => 'prayer',
			'tax_input' => [ 'prayer_category' => implode(',', $post['prayer_category']), 'prayer_location' => implode(',', $post['prayer_location']) ]
		);


		// create the pending prayer request
		$prayer_id = wp_insert_post($prayer);
	}

}

add_action( 'init', 'prayer_submission' );
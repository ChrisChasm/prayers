<?php

/**
* Plugin Name: Echo Prayer App
* Plugin URI: http://github.com/kalebheitzman/echo
* Description: Lets an organization share and update prayer requests via their website. This plugin also provides JSON feeds for other services to consume and requires the <a href="https://wordpress.org/plugins/rest-api/">WP REST API</a> be installed and activated first.
* Version: 1.0
* Author: Kaleb Heitzman
* Author URI: http://github.com/kalebheitzman/echo
* License: MIT
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// requir the REST API plugin
function echo_plugin_activate(){

    // Require parent plugin
    if ( ! is_plugin_active( 'rest-api/plugin.php' ) and current_user_can( 'activate_plugins' ) ) {
        // Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires the <a href="https://wordpress.org/plugins/rest-api/">WP REST API (Version 2)</a> to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}
register_activation_hook( __FILE__, 'echo_plugin_activate' );

define( 'ECHO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// load template loader
require ECHO_PLUGIN_DIR . 'includes/class-gamajo-template-loader.php';
require ECHO_PLUGIN_DIR . 'includes/class-echo-template-loader.php';

// load template helpers
require ECHO_PLUGIN_DIR . 'includes/template-helpers.php';

// load styles
require ECHO_PLUGIN_DIR . 'includes/scripts.php';
add_action( 'wp_enqueue_scripts', 'echo_register_styles' );

// load prayer post type
require ECHO_PLUGIN_DIR . 'includes/post_type_prayer.php';
add_action( 'init', 'prayer_post_type', 0 );

// add post type menu
require ECHO_PLUGIN_DIR . 'includes/post_type_menu.php';
add_action('admin_menu' , 'prayer_feeds_menu', 0 );
add_action('admin_menu' , 'prayer_settings_menu', 0 );

// load prayer taxonomies
require ECHO_PLUGIN_DIR . 'includes/taxonomy_prayer_category.php';
require ECHO_PLUGIN_DIR . 'includes/taxonomy_prayer_location.php';
require ECHO_PLUGIN_DIR . 'includes/taxonomy_prayer_post_tag.php';
add_action( 'init', 'prayer_category_taxonomy', 1 );
add_action( 'init', 'prayer_location_taxonomy', 2 );
add_action( 'init', 'prayer_post_tag_taxonomy', 3 );

// load shortcodes
require ECHO_PLUGIN_DIR . 'includes/shortcodes.php';
add_shortcode( 'prayers', 'prayers_shortcode' );

// load post meta
require ECHO_PLUGIN_DIR . 'includes/post_type_meta.php';

// prayer form submission
function echo_prayer_form_submission() {

	if ( isset( $_POST['prayer-submission']) && '1' == $_POST['prayer-submission']) {
		// check for a valid nonce
		$is_valid_nonce = ( isset( $_POST[ 'prayer_nonce' ] ) && wp_verify_nonce( $_POST[ 'prayer_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false'; 
	    // Exits script depending on save status
	    if ( !$is_valid_nonce ) {
	        return;
	    }

		$post = $_POST;

		$prayer_category = term_exists( $post['prayer_category'], 'prayer_category', 0 );
		$prayer_location = term_exists( $post['prayer_location'], 'prayer_location', 0 );

		if ( ! $prayer_category ) {
			$prayer_category = wp_insert_term( $prayer_category, 'prayer_category', array( 'parent' => 0 ) );
		}

		if ( ! $prayer_location ) {
			$prayer_location = wp_insert_term( $prayer_location, 'prayer_location', array( 'parent' => 0 ) );
		}

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

		add_post_meta( $prayer_id, 'meta-prayer-anonymous', $post['prayer_anonymous'] );
		add_post_meta( $prayer_id, 'meta-prayer-answered', 0);
		add_post_meta( $prayer_id, 'meta-prayer-name', $post['prayer_name'] );
		add_post_meta( $prayer_id, 'meta-prayer-email', $post['prayer_email'] );
	}

}
add_action( 'init', 'echo_prayer_form_submission' );

// update prayer count
function echo_prayed_click_submit() {

	if ( isset( $_POST['prayer-click']) && '1' == $_POST['prayer-click']) {
		// check for a valid nonce
		$is_valid_nonce = ( isset( $_POST[ 'prayer_nonce' ] ) && wp_verify_nonce( $_POST[ 'prayer_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false'; 
	    // Exits script depending on save status
	    if ( !$is_valid_nonce ) {
	        return;
	    }

		$post = $_POST;

		$count = get_post_meta( $post['prayer_id'], 'meta-prayer-count', 1 );
		if ( empty($count) ) {
			$count = 0;
		}

		$count++;

		update_post_meta( $post['prayer_id'], 'meta-prayer-count', $count );

	}
}
add_action( 'init', 'echo_prayed_click_submit');
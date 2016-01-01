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

class Echo_Form_Processing {

	/**
	 * GUMP Validation Library
	 * @var object
	 */
	public $gump;

	/**
	 * Class Construct
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'prayer_form_submission' ) );
		add_action( 'init', array( $this, 'prayed_click_submit') );

		// setup php based validation
		$this->gump = new GUMP();
		$this->set_validation_rules();
		$this->set_validation_filters();
	}

	/**
	 * Set Validation Rules for the frontend form
	 * @since  0.9.0 
	 */
	function set_validation_rules() {
		$rules = array(
			'prayer_title' => 'required|min_len,6',
			'prayer_content' => 'required|min_len,6',
			'prayer_name' => 'required,min_len,2',
			'prayer_email' => 'required,valid_email',
			'prayer_category' => 'required'
			// 'prayer_location' => '',
			// 'prayer_tags' => '',
		);
		$this->gump->validation_rules( $rules );
	}

	/**
	 * Set Validation Filters
	 * @since  0.9.0 
	 */
	function set_validation_filters() {
		$filters = array(
			'prayer_title' => 'trim|sanitize_string',
			'prayer_content' => 'trim|sanitize_string',
			'prayer_name' => 'trim|sanitize_string',
			'prayer_email' => 'trim|sanitize_email',
			'prayer_location' => 'trim|sanitize_string',
			'prayer_tags' => 'trim|sanitize_string',
		);
		$this->gump->filter_rules( $filters );
	}

	/**
	 * Prayer Form Processor
	 *
	 * Processes frontend prayer form submissions based on the [prayers_form]
	 * shortcode. Checks against a nonce to prevent cross site hacking. 
	 *
	 * @since  0.9.0
	 */
	function prayer_form_submission() {
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
			$validated_data = $this->gump->run( $post );
			// failed validation
			if ( $validated_data === false ) {
				session_start();
				// get the errors
				$errors = $this->gump->get_readable_errors( false );
				$_SESSION['errors'] = $errors;
				$_SESSION['post'] = $post;

			// passed validation
			} else {
				// data saved, display confirmation
				if ( $this->save_validated_data( $validated_data ) ) {
					// get a virtual page created from Echo_Virtual_Pages
					$url = get_site_url() . "/prayers/confirmation";
					// attempt redirect with js
					printf("<script>location.href='/prayers/confirmation'</script>");
					// meta refresh backup
					echo '<META HTTP-EQUIV="Refresh" Content="0; URL=/prayers/confirmation">';    
				    exit;
				}
				else {
					
				}
			}
		}
	}

	/**
	 * Save Validated Data
	 *
	 * @since 0.9.0 
	 */
	private function save_validated_data( $data = null ) {
		if ( null == $data ) return;

		// check to make sure the taxonomy term exists and insert if it does not
		$prayer_category = term_exists( $data['prayer_category'], 'prayer_category', 0 );
		if ( ! $prayer_category ) {
			$prayer_category = wp_insert_term( $prayer_category, 'prayer_category', array( 'parent' => 0 ) );
		}

		// check for taxonomy tags
		$tags = explode( ',', $data['prayer_tags'] );
	
		// get the echo user
		$user = get_user_by( 'login', 'echo' );

		// build a prayer entry to be insterted into the db
		$prayer = array(
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_author' => $user->id,
			'post_title' => $data['prayer_title'],
			'post_content' => $data['prayer_content'],
			'post_status' => 'pending',
			'post_type' => 'prayer',
			'tax_input' => [ 'prayer_category' => $prayer_category['term_taxonomy_id'], 'prayer_tag' => $tags ],
		);
		// create the pending prayer request
		$prayer_id = wp_insert_post($prayer);
		// add meta to the prayer after insert. You have to get a post id
		// before being able to insert meta.
		add_post_meta( $prayer_id, 'meta-prayer-anonymous', $data['prayer_anonymous'] );
		add_post_meta( $prayer_id, 'meta-prayer-answered', 0);
		add_post_meta( $prayer_id, 'meta-prayer-count', 0);
		add_post_meta( $prayer_id, 'meta-prayer-name', $data['prayer_name'] );
		add_post_meta( $prayer_id, 'meta-prayer-email', $data['prayer_email'] );
		add_post_meta( $prayer_id, 'meta-prayer-location', $data['prayer_location'] );
		// set the language of the post
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
		add_post_meta( $prayer_id, 'meta-prayer-lang', $lang );
		// calculate coordinates and store them 
		$location = Echo_Plugin_Helper::parse_location($data['prayer_location']);
		Echo_Plugin_Helper::save_location_meta( $prayer_id, $location );

		return true;
	}

	/**
	 * Prayer Click Submission
	 *
	 * Process prayer click submissions by incremting the prayer count for
	 * individual prayer posts.
	 *
	 * @since 0.9.0 
	 */
	function prayed_click_submit() {
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
}
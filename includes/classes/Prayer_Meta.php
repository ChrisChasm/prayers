<?php
/**
 * Build Meta Boxes
 *
 * Build the metabox used for the Prayer edit page. This adds options for 
 * storing name, email, and location, as well as other metadata. This is also 
 * where the meta save process is found. It's straightforward other than a
 * call to process location data using the prayer_save_meta_location plugin 
 * helper.
 * 
 * @package   Prayer
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/prayer
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

class Prayer_Meta
{

	/**
     * The ID of this plugin.
     *
     * @since    0.9.0
     * @access   private
     * @var      string    $name    The ID of this plugin.
     */
    private $name;
 
    /**
     * The version of this plugin.
     *
     * @since    0.9.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
 
    /**
     * Initialize the class and set its properties.
     *
     * @since    0.9.0
     * @var      string    $name       The name of this plugin.
     * @var      string    $version    The version of this plugin.
     */
    public function __construct( $name, $version ) {
 
        $this->name = $name;
        $this->version = $version;

        add_action( 'add_meta_boxes', array( $this, 'prayer_add_metabox' ) );
		add_action( 'save_post', array( $this, 'prayer_meta_save' ) );
 
    }

	/**
	 * Build Prayer Meta Box
	 * @since  0.9.0
	 */
	public function prayer_add_metabox() {
		add_meta_box(
			'prayer-meta', 
			__('Prayer Meta', 'prayer'), 
			array( $this, 'display_meta_box' ), 
			'prayer', 
			'normal', 
			'high');
	}

	/**
	 * HTML Output Callback
	 * @param  object Post object
	 * @return html
	 * @since 0.9.0
	 */
	public function display_meta_box( $post ) {

		// get the post meta
		$post_meta = get_post_meta( $post->ID );

		// load the metabox html
		$views = plugin_dir_path( __FILE__ ) . "../views/";
		include_once( $views . 'prayer-meta-box.php' );

		
	    
	}

	/**
	 * Save the meta information
	 * @param  integer Post ID
	 * @since  0.9.0
	 */
	public function prayer_meta_save( $post_id = 0 ) {
		if ( $post_id == 0 ) return;

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
	    if( isset( $_POST[ 'meta-prayer-name' ] ) ) {
	    	update_post_meta( $post_id, 'meta-prayer-name', sanitize_text_field( $_POST[ 'meta-prayer-name' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'meta-prayer-email' ] ) ) {
	    	update_post_meta( $post_id, 'meta-prayer-email', sanitize_text_field( $_POST[ 'meta-prayer-email' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'meta-prayer-location' ] ) ) {
	    	update_post_meta( $post_id, 'meta-prayer-location', sanitize_text_field( $_POST[ 'meta-prayer-location' ] ) );

	    	// get geocoded data from location
	    	$location = Prayer_Plugin_Helper::parse_location( sanitize_text_field( $_POST[ 'meta-prayer-location' ] ) );
	    	Prayer_Plugin_Helper::save_location_meta( $post_id, $location );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'meta-prayer-count' ] ) ) {
	    	update_post_meta( $post_id, 'meta-prayer-count', sanitize_text_field( $_POST[ 'meta-prayer-count' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if ( isset( $POST[ 'meta-prayer-lang' ] ) ) {
	    	update_post_meta( $post_id, 'meta-prayer-lang', sanitize_text_field($_POST['meta-prayer-lang']) );
	    }

	}

}
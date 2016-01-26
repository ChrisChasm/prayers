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
 * @copyright 2016 Kaleb Heitzman
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
    global $post;
		if ( $post_id == 0 || $post->post_type != 'prayer' ) return;

		// Checks save status
	    $is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    $is_valid_nonce = ( isset( $_POST[ 'prayer_nonce' ] ) && wp_verify_nonce( $_POST[ 'prayer_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	    // Exits script depending on save status
	    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
	        return;
	    }

      // get the prayer settings
      $prayer_settings = get_option( 'prayer_settings_options' );

      // update the post title
      if ( empty( $_POST['post_title'] ) ) {
        // build a title
        // $title_parts[] = $category->name;
        $title_parts[] = $_POST[ 'prayer-name' ];
        $title_parts[] = date('YmdHi');
        $title = implode(" on ", $title_parts);

        remove_action( 'save_post', array( $this, 'prayer_meta_save' ) );
        wp_update_post( array( 'ID' => $post_id, 'post_title' => $title ) );
        add_action( 'save_post', array( $this, 'prayer_meta_save' ) );
      }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'prayer-answered' ] ) ) {
	        update_post_meta( $post_id, 'prayer-answered', sanitize_text_field( $_POST[ 'prayer-answered' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'prayer-anonymous' ] ) && $_POST[ 'prayer-anonymous' ] == '1' ) {
	        update_post_meta( $post_id, 'prayer-anonymous', sanitize_text_field( $_POST[ 'prayer-anonymous' ] ) );

          // set the visibility to private
          remove_action( 'save_post', array( $this, 'prayer_meta_save' ) );
          wp_update_post( array( 'ID' => $post_id, 'post_status' => 'private' ) );
          add_action( 'save_post', array( $this, 'prayer_meta_save' ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'prayer-name' ] ) ) {
	    	update_post_meta( $post_id, 'prayer-name', sanitize_text_field( $_POST[ 'prayer-name' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'prayer-email' ] ) && ! empty( $_POST[ 'prayer-email' ] ) ) {
	    	update_post_meta( $post_id, 'prayer-email', sanitize_text_field( $_POST[ 'prayer-email' ] ) );
	    }
      else {
        // if not enabled skip pulling the email
        if ( $prayer_settings['mailchimp_magic_enabled'] == "0" ) return;
        // attempt to pull email from Existing MailChimp List
        global $prayer_mailchimp;
        if ( ! empty( $prayer_mailchimp->mc_api->apikey ) ) {

          $name = $_POST[ 'prayer-name' ];
          $name_parts = explode( ' ', $name );
          $query = $name;
          $members = $prayer_mailchimp->mc_api->helper->searchMembers( $query, $prayer_mailchimp->current_list );

          foreach( $members['full_search']['members'] as $member ) {

            $fname = $member['merges']['FNAME'];
            $lname = $member['merges']['LNAME'];

            if ( ( $fname == $name_parts[0] ) && ( $lname = $name_parts[1] ) ) {
              $email = $member['email'];
              update_post_meta( $post_id, 'prayer-email', $email );
            }

          }

        }

      }

      // Checks for input and sanitizes/saves if needed
	    if ( isset( $_POST[ 'prayer-map-enabled' ] ) ) {
	    	update_post_meta( $post_id, 'prayer-map-enabled', sanitize_text_field($_POST['prayer-map-enabled']) );
	    } else {
	    	update_post_meta( $post_id, 'prayer-map-enabled', 0 );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'prayer-lang' ] ) ) {
	    	update_post_meta( $post_id, 'prayer-lang', sanitize_text_field( $_POST[ 'prayer-lang' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'prayer-location' ] ) ) {
	    	update_post_meta( $post_id, 'prayer-location', sanitize_text_field( $_POST[ 'prayer-location' ] ) );

	    	// get geocoded data from location
	    	$location = Prayer_Plugin_Helper::parse_location( sanitize_text_field( $_POST[ 'prayer-location' ] ) );
	    	Prayer_Plugin_Helper::save_location_meta( $post_id, $location );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'prayer-count' ] ) ) {
	    	update_post_meta( $post_id, 'prayer-count', sanitize_text_field( $_POST[ 'prayer-count' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if ( isset( $POST[ 'prayer-lang' ] ) ) {
	    	update_post_meta( $post_id, 'prayer-lang', sanitize_text_field($_POST['prayer-lang']) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if ( isset( $_POST[ 'prayer-prayed' ] ) ) {
	    	update_post_meta( $post_id, 'prayer-prayed', sanitize_text_field($_POST['prayer-prayed']) );
	    } else {
	    	update_post_meta( $post_id, 'prayer-prayed', 0 );
	    }

      // Checks for input and sanitizes/saves if needed
	    if ( isset( $_POST[ 'prayer-email-ready-for-sync' ] ) ) {
	    	update_post_meta( $post_id, 'prayer-email-ready-for-sync', sanitize_text_field($_POST['prayer-email-ready-for-sync']) );
	    } else {
	    	update_post_meta( $post_id, 'prayer-email-ready-for-sync', 0 );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if ( isset( $_POST[ 'prayer-email-synced' ] ) ) {
	    	update_post_meta( $post_id, 'prayer-email-synced', sanitize_text_field($_POST['prayer-email-synced']) );
	    } else {
	    	update_post_meta( $post_id, 'prayer-email-synced', 0 );
	    }

	    //
	    if ( ! empty( $_POST['prayer-response'] ) ) {
	    	update_post_meta( $post_id, 'prayer-response', esc_textarea( $_POST['prayer-response'] ) );
	    }

	    // If the 'Resources' inputs exist, iterate through them and sanitize them
		if ( ! empty( $_POST['prayer-notes'] ) ) {

		    $notes = $_POST['prayer-notes'];
		    $sanitized_notes = array();
		    foreach ( $notes as $note ) {

		        $note = esc_textarea( strip_tags( $note ) );

		        if ( ! empty ( $note ) ) {
		        	$sanitized_notes[] = $note;
		        }
		    }
		    update_post_meta( $post_id, 'prayer-notes', $sanitized_notes );

		} else {
			if ( '' !== get_post_meta( $post_id, 'prayer-notes', true ) ) {
				delete_post_meta( $post_id, 'prayer-notes' );
			}
		}

	}

}

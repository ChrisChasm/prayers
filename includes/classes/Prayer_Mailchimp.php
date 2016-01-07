<?php
/**
 * Mailchimp Class
 *
 * Allows frontened users to login via thier email and a token link
 * 
 * @package   Prayer
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/prayer
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */
class Prayer_Mailchimp
{
	public $mc_api;

	public $mc_segments;

	public $current_list = "";

	/**
	 * Class Construct
	 *
	 * @since  0.9.0
	 */
	public function __construct()
	{
		$settings = get_option( 'prayer_settings_options' );
		$api_key = $settings['mailchimp_api_key'];

		// set the mailchimp api
		if ( ! empty($api_key) ) {
			$this->mc_api = new Mailchimp( $api_key );			
		}
		// set the current list
		$this->current_list = get_option( 'prayer_mailchimp_list' ); 

		// add a form processor 
		add_action( 'init', array( $this, 'set_mailchimp_list_submission' ) );
		add_action( 'init', array( $this, 'sync_mailchimp_list_submission' ) );
		add_action( 'init', array( $this, 'sync_mailchimp_segment' ) );

		// set a list of segments available in mc list
		$this->mc_segments = array();
	}

	/**
	 * Capture List Sync Submission
	 *
	 * @since 0.9.0
	 */
	public function sync_mailchimp_list_submission()
	{
		// check to see if this is a prayer submission
		if ( isset( $_POST['mailchimp-sync-list']) && '1' == $_POST['mailchimp-sync-list']) 
		{
			// check for a valid nonce
			$is_valid_nonce = ( isset( $_POST[ 'mailchimp_nonce' ] ) && wp_verify_nonce( $_POST[ 'mailchimp_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false'; 
		    // Exits script depending on save status
		    if ( ! $is_valid_nonce ) {
		        return;
		    }
			$this->sync_mailchimp_list();
		}
	}

	/**
	 * Sync MailChimp List
	 */
	public function sync_mailchimp_list()
	{
		// get the list id	
		if ( ! empty($this->current_list) )
		{
			// get a list of all emails and names
			$emails = Prayer_Sql::get_all_emails();

			$batch = array();
			foreach ( $emails as $email )
			{
				$name = $item->name;
				$name_parts = explode( " ", $name );
				$fname = array_shift( $name_parts );
				$lname = implode( "", $name_parts );
				$batch[] = array(
					'email' => array( 'email' => $email->email ),
					'merge_vars' => array( 'fname' => $fname, 'lname' => $lname )
				);
			}

			// batch subscribe 
			try {
				$results = $this->mc_api->lists->batchSubscribe( $this->current_list, $batch, false, true, true );
				Prayer_Template_Helper::set_flash_message( __( 'Successfully synced your MailChimp List.', 'prayer' ) );
			} catch ( Mailchimp_Error $e ) {
				if ( $e->getMessage() ) {
					Prayer_Template_Helper::set_flash_message( __( $e->getMessage(), 'prayer' ), 'error' );
				}
				else {
					Prayer_Template_Helper::set_flash_message( __( 'An unknown error occurred', 'prayer' ), 'error' );
				}
			}
		}
	}
	
	/**
	 * Sync Segment
	 *
	 * @since  0.9.0
	 */
	public function sync_mailchimp_segment()
	{
		// check to see if this is a prayer submission
		if ( isset( $_POST['mailchimp-sync-segment']) && '1' == $_POST['mailchimp-sync-segment']) 
		{
			// check for a valid nonce
			$is_valid_nonce = ( isset( $_POST[ 'mailchimp_nonce' ] ) && wp_verify_nonce( $_POST[ 'mailchimp_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false'; 
		    // Exits script depending on save status
		    if ( ! $is_valid_nonce ) {
		        return;
		    }
		    // get the post
			$post = $_POST;
			$segment = $post['segment'];

			switch ($segment)
			{
				case 'unanswered-requests':

					break;

				case 'new-prayed-requests':
					$emails = Prayer_Sql::get_newly_prayed();
					$this->sync_segment_by_name( 'Newly Prayed', $emails );
					break;
			}
		}
	}
	
	/**
	 * Sync Segment by Name
	 * @param  string $segment Name of Segment
	 * @param  object $emails  WPDB Object
	 */
	public function sync_segment_by_name( $segment, $emails )
	{
		$this->sync_mailchimp_list();

		// get all segments to test against
		$segments = $this->mc_api->lists->staticSegments( $this->current_list );
		$segment_exists = Prayer_Plugin_Helper::in_array_rec($segment, $segments);

		// reset the segment if it exists
		if ( $segment_exists)
		{
			foreach( $segments as $key => $item )
			{
				if ( $item['name'] == $segment) {
					$segment_id = $segments[$key]['id'];
				}
			}
			$this->mc_api->lists->staticSegmentReset( $this->current_list, $segment_id );
		}
		// create a new segment if it doesn't exist
		else
		{
			$segment_id = $this->mc_api->lists->staticSegmentAdd( $this->current_list, $segment );
		}

		// build the batch
		foreach ( $emails as $email )
		{
			$batch[] = array(
				'email' => $email->email
			);
		}
		// batch subscribe 
		try {
			$results = $this->mc_api->lists->staticSegmentMembersAdd( $this->current_list, $segment_id, $batch );
			Prayer_Template_Helper::set_flash_message( __( 'Successfully synced your MailChimp Segment: ' . $segment, 'prayer' ) );
		} catch ( Mailchimp_Error $e ) {
			if ( $e->getMessage() ) {
				Prayer_Template_Helper::set_flash_message( __( $e->getMessage(), 'prayer' ), 'error' );
			}
			else {
				Prayer_Template_Helper::set_flash_message( __( 'An unknown error occurred', 'prayer' ), 'error' );
			}
		}
	}

	/**
	 * MailChimp List Selection
	 *
	 * @since  0.9.0 
	 */
	public function set_mailchimp_list_submission()
	{
		// check to see if this is a prayer submission
		if ( isset( $_POST['mailchimp-submission']) && '1' == $_POST['mailchimp-submission']) 
		{
			// check for a valid nonce
			$is_valid_nonce = ( isset( $_POST[ 'mailchimp_nonce' ] ) && wp_verify_nonce( $_POST[ 'mailchimp_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false'; 
		    // Exits script depending on save status
		    if ( ! $is_valid_nonce ) {
		        return;
		    }
		    // get the post
			$post = $_POST;
			update_option( 'prayer_mailchimp_list', $post['prayer_mailchimp_list'] );
		}
	}

}
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
		add_action( 'init', array( $this, 'mailchimp_list_submission' ) );
		add_action( 'init', array( $this, 'sync_mailchimp_list' ) );
		add_action( 'init', array( $this, 'sync_mailchimp_segment' ) );
	}

	/**
	 * Authorize Mailchimp
	 *
	 * @since  0.9.0
	 */
	public function authorize_mailchimp()
	{

	}

	/**
	 * Sync List
	 *
	 * @since 0.9.0
	 */
	public function sync_mailchimp_list()
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
			// get the list id	
			if ( ! empty($this->current_list) )
			{
				// get a list of all emails and names
				$emails = Prayer_Sql::get_all_emails();

				// get all unique emails and names
				$emails_filtered = array();
				foreach ( $emails as $item ) 
				{
					$email = $item->email;
					$name = $item->name;

					if ( ! Prayer_Plugin_Helper::in_array_rec( $email, $emails_filtered) )
					{
						$name = $item->name;
						$name_parts = explode( " ", $name );
						$fname = array_shift( $name_parts );
						$lname = implode( "", $name_parts );
						$emails_filtered[] = array(
							'email' => array( 'email' => $item->email ),
							'merge_vars' => array( 'fname' => $fname, 'lname' => $lname )
						);
					}
				}

				// batch subscribe 
				try {
					$this->mc_api->lists->batchSubscribe( $this->current_list, $emails_filtered, true, true, true );
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

					break;
			}
		}
	}
	
	/**
	 * MailChimp List Selection
	 *
	 * @since  0.9.0 
	 */
	public function mailchimp_list_submission()
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
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

	}
	
	/**
	 * Sync Segment
	 *
	 * @since  0.9.0
	 */
	public function sync_mailchimp_segment()
	{

	}
	
	/**
	 * MailChimp List Selection
	 *
	 * @since  0.9.0 
	 */
	public function mailchimp_list_submission()
	{
		// check to see if this is a prayer submission
		if ( isset( $_POST['mailchimp-submission']) && '1' == $_POST['mailchimp-submission']) {
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
<?php
/**
 * Authentication Class
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
class Prayer_Auth
{
	/**
	 * Class Construct
	 *
	 * @since  0.9.0
	 */
	public function __construct()
	{
		add_action( 'init', array( $this, 'send_email' ) );

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
			'prayer_email' => 'required,valid_email',
		);
		$this->gump->validation_rules( $rules );
	}

	/**
	 * Set Validation Filters
	 * @since  0.9.0 
	 */
	function set_validation_filters() {
		$filters = array(
			'prayer_email' => 'trim|sanitize_email',
		);
		$this->gump->filter_rules( $filters );
	}

	/**
	 * Send Email
	 *
	 * Captures email address form prayers-send-token form and generates a 
	 * token, stories in the database, and send a link via email to the user.
	 * This allows users to manage thier content without a password. 
	 *
	 * @since 0.9.0
	 */
	public function send_email()
	{
		// check to see if this is a token submission
		if ( isset( $_POST['prayers-send-token']) && '1' == $_POST['prayers-send-token']) {
			// check for a valid nonce
			$is_valid_nonce = ( isset( $_POST[ 'prayer_nonce' ] ) && wp_verify_nonce( $_POST[ 'prayer_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false'; 
		    // Exits script depending on save status
		    if ( ! $is_valid_nonce ) {
		        return;
		    }
		    // generate a token
		     
		    // load the email template
		    
		    // send the email
		}
	}

	public function generate_token()
	{

		return $token;
	}

	public function validate_token( $token = null )
	{
		if ( is_null($token) ) return false;
		
		return true;
	}

	public function authorize()
	{
		
	}

}
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
	/**
	 * Class Construct
	 *
	 * @since  0.9.0
	 */
	public function __construct()
	{
		$settings = get_option( 'prayer_settings_options' );
		$api_key = $settings['mailchimp_api_key'];
		
		if ( ! empty($api_key) ) {
			$this->mc = new Mailchimp( $api_key );			
		}

		// var_dump($this->mc->lists);
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
	
}
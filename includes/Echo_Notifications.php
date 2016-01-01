<?php
/**
 * Prayer Notifications
 *
 * Notifies users about incoming prayer requests.
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */
class Echo_Notifications
{

	/**
	 * Notify Echo user of new request
	 * @param  post
	 * @since 0.9.0 
	 */
	static public function new_request( $data = null )
	{
		if ( $data == null ) return;

		// get user to notify
		$user = get_user_by( 'login', 'echo' );
		$email = $user->data->user_email;
		if ( ! empty( $email ) ) {

			$subject = __('New Web Prayer Request', 'echo' );

			$body = "{$data['prayer_content']}\r\n\n";
			$body .= "From: {$data['prayer_name']} <{$data['prayer_email']}>";
			$body .= "Location: {$data['prayer_location']} \r\n";

			return wp_mail( $email, $subject, $body );
		}

		return false;
	}

}
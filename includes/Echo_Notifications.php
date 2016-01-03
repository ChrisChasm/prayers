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

			// set var to be accessible in the called template
			set_query_var( 'data', $data );

			// load templates
			$templates = new Echo_Template_Loader;
			// start a buffer to capture output
			ob_start();
			$templates->get_template_part( 'email', 'notification' );
			$body = ob_get_clean();

			return wp_mail( $email, $subject, $body );
		}

		return false;
	}

}
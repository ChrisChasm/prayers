<?php
/**
 * Prayer Virtual Pages
 *
 * Virtual pages used with the Prayer Plugin.
 * 
 * @package   Prayer
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/prayer
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */
class Prayer_Virtual_Pages
{
	/**
	 * Class Construct
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'create_form_submitted_page' ) );
	}

	/**
	 * Prayer Form Confirmation Page
	 *
	 * This takes the form confirmation set under settings and creates a
	 * virtual page at /prayer-confirmation.
	 *
	 * @since 0.9.0
	 */
	public function create_form_submitted_page() {
		$url = trim( parse_url ( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
		if ( $url == 'prayers/confirmation' ) {
			// get custom notification
			$prayer_options = get_option( 'prayer_settings_options' );
			$content = $prayer_options['prayer_form_response'];
			// build the args
			$args = array( 
				'title' => 'Prayer Received',
				'slug' => 'prayers/confirmation',
				'content' => wpautop( $content )
			);
			$page = new Prayer_Virtual_Page( $args );
		}
	}

}
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

	protected $slug;

	/**
	 * Class Construct
	 */
	public function __construct() {

		$this->slug = trim( parse_url ( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );

		// prayers pages
		add_action( 'init', array( $this, 'get_prayers' ) );
		add_action( 'init', array( $this, 'get_prayers_map' ) );

		// submit a requests page
		add_action( 'init', array( $this, 'get_prayers_submit' ) );
		add_action( 'init', array( $this, 'get_prayers_confirmation' ) );

		// authenticated pages
		add_action( 'init', array( $this, 'get_prayers_login' ) );
		add_action( 'init', array( $this, 'get_prayers_manage' ) );

	}

	/**
	 * Prayers Listing
	 *
	 * Creates a page at /prayers
	 * This creates a paginated and queryable listing of prayers page where
	 * users can pray for others requests, view requests, etc
	 *
	 * @since  0.9.0
	 */
	public function get_prayers()
	{
		if ( isset( $_GET['logout'] ) && $_GET['logout'] == 1 ) {
			unset($_COOKIE['wp-prayer-jwt']);
		}

		if ( $this->slug == 'prayers' ) {
			// build the args
			$args = array( 
				'title' => 'Prayers',
				'slug' => 'prayers',
				'content' => do_shortcode( '[prayers]' )
			);
			$page = new Prayer_Virtual_Page( $args );
		}
	}

	/**
	 * Prayers Map
	 *
	 * Creates a page at /prayers/map
	 * This creates a paginated and queryable listing of prayers page where
	 * users can pray for others requests, view requests, etc
	 *
	 * @since  0.9.0
	 */
	public function get_prayers_map()
	{
		if ( $this->slug == 'prayers/map' ) {
			// build the args
			$args = array( 
				'title' => 'Prayer Map',
				'slug' => 'prayers/map',
				'content' => do_shortcode( '[prayer_map]' )
			);
			$page = new Prayer_Virtual_Page( $args );
		}
	}

	/**
	 * Submit a prayer
	 *
	 * Creates a page at prayers/submit
	 * Gives users the ability to submit prayer requests to your website.
	 */
	public function get_prayers_submit()
	{
		if ( $this->slug == 'prayers/submit' ) {
			// build the args
			$args = array( 
				'title' => 'Submit a prayer',
				'slug' => 'prayers/submit',
				'content' => do_shortcode( '[prayer_form]' )
			);
			$page = new Prayer_Virtual_Page( $args );
		}
	}

	/**
	 * Prayer Form Confirmation Page
	 *
	 * GET /prayers/confirmation
	 * This takes the form confirmation set under settings and creates a
	 * virtual page at /prayer-confirmation.
	 *
	 * @since 0.9.0
	 */
	public function get_prayers_confirmation() {
		
		if ( $this->slug == 'prayers/confirmation' ) {
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

	/**
	 * Login by Email Link
	 *
	 * GET /prayers/login
	 * Creates a page to allow anonymous users to login by email through a 
	 * token sent to thier email. This helps prevents users from having to 
	 * remember a password. 
	 * 
	 * @since  0.9.0
	 */
	public function get_prayers_login() {
		if ( $this->slug == 'prayers/login' ) {
			// build the args
			$args = array( 
				'title' => 'Prayers Login',
				'slug' => 'prayers/login',
				'content' => do_shortcode( '[prayer_auth_form]' )
			);
			$page = new Prayer_Virtual_Page( $args );
		}
	}

	/**
	 * Mange my prayers
	 *
	 * GET /prayers/manage
	 * Allows a user to manage and interact with thier prayer requests after
	 * having been authenticated via a token. The token is generated and sent
	 * via a link to the users email bypassing any sort of password needs.
	 */
	public function get_prayers_manage()
	{
		$token = $_GET['token'];

		// build the prayers/manage page
		if ( $this->slug == 'prayers/manage' ) {

			// decode the token, if it fails, the authenticate method
			// will redirect to GET /prayers
			$authenticated = Prayer_Auth::authenticate( $token );

			// build the args
			$args = array( 
				'title' => 'My Prayers',
				'slug' => 'prayers/manage',
				'content' => do_shortcode( '[prayers_manage email="' . $authenticated->sub . '"]' )
			);
			$page = new Prayer_Virtual_Page( $args );
		}
	}

}
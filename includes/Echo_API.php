<?php
/**
 * Echo Prayer JSON API
 *
 * Outputs JSON responses from /prayers/api.
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

class Echo_API
{
	/**
	 * Class Construct
	 * @since 0.9.0 
	 */
	public function __construct()
	{
		add_action( 'rest_api_init', array( $this, 'api' ) );
		add_action( 'rest_api_init', array( $this, 'api_category' ) );
		add_action( 'rest_api_init', array( $this, 'api_tags' ) );
		add_action( 'rest_api_init', array( $this, 'api_location' ) );
	}

	/**
	 * GET /prayers/api
	 * @since 0.9.0
	 */
	public function api() 
	{
		
	}

	/**
	 * GET /prayer/api/category/{category}
	 * @since 0.9.0
	 */
	public function api_category()
	{

	}

	/**
	 * GET /prayer/api/tags/{tags}
	 * @since 0.9.0
	 */
	public function api_tags()
	{
		
	}

	/**
	 * GET /prayer/api/location/{location}
	 * @since 0.9.0
	 */
	public function api_location()
	{
		
	}

}
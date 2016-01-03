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
		add_action( 'rest_api_init', function() {
			register_rest_route( 'echo/v1', '/prayers', array(
				'methods' => 'GET',
				'callback' => array( $this, 'api' )
			) );
		});
	}

	/**
	 * GET /prayers/api
	 * @since 0.9.0
	 */
	public function api( WP_REST_Request $request ) 
	{
		var_dump($request); die();
		// You can access parameters via direct array access on the object:
	    $param = $request['some_param'];

	    // Or via the helper method:
	    $param = $request->get_param( 'some_param' );

	    // You can get the combined, merged set of parameters:
	    $parameters = $request->get_params();

	    // The individual sets of parameters are also available, if needed:
	    $parameters = $request->get_url_params();
	    $parameters = $request->get_query_params();
	    $parameters = $request->get_body_params();
	    $parameters = $request->get_default_params();

		return [];
	}

	/**
	 * GET /prayer/api/category/{category}
	 * @since 0.9.0
	 */
	public function api_category()
	{
		return [];
	}

	/**
	 * GET /prayer/api/tags/{tags}
	 * @since 0.9.0
	 */
	public function api_tags()
	{
		return [];
	}

	/**
	 * GET /prayer/api/location/{location}
	 * @since 0.9.0
	 */
	public function api_location()
	{
		return [];
	}

}
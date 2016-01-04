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
		add_action( 'rest_api_init', array( $this, 'register_get_api' ) );
		add_action( 'rest_api_init', array( $this, 'register_get_prayers' ) );
	}

	/**
	 * Register /echo/v1/
	 * @since  0.9.0
	 */
	public function register_get_api()
	{
		return register_rest_route( 'echo/v1', '/', array(
				'methods' => 'GET',
				'callback' => array( $this, 'api' )
		) );
	}

	/**
	 * GET echo/v1
	 * @since 0.9.0
	 */
	public function api( WP_REST_Request $request ) 
	{
		// var_dump($request); die();
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
	 * Register echo/v1/prayers
	 * @since  0.9.0
	 */
	public function register_get_prayers()
	{
		return register_rest_route( 'echo/v1', '/prayers', array(
				'methods' => 'GET',
				'callback' => array( $this, 'get_prayers' )
		) );
	}

	/**
	 * GET echo/v1/prayers
	 * @since  0.9.0
	 */
	public function get_prayers()
	{
		// WP_Query arguments
		$args = array (
			'post_type' => array( 'prayer' ),
			'post_status' => array( 'publish' ),
			'paged' => $paged,
			'posts_per_page' => $limit,
			'meta_query' => array(
				array(
					'key' => 'meta-prayer-anonymous', // filters out anonymous prayers
					'value' => 0,
					'compare' => 'LIKE',
				),
			),
		);

		// The Query
		$query = new WP_Query( $args );
		$prayers = $query->get_posts();

		foreach ($prayers as $key => $prayer) {
			
			// get the post meta
			$meta = get_post_meta( $prayer->ID );
			//$prayers[$key]->meta = $meta;

			// set the prayer count
			$prayers[$key]->prayer_count = $meta['meta-prayer-count'][0];

			// set the user info
			$prayers[$key]->submitter = array(
				'name' => $meta['meta-prayer-name'][0]
			);

			// set the location data
			$lon = $meta['meta-prayer-location-longitude'];
			$lat = $meta['meta-prayer-location-latitude'];
			$add = $meta['meta-prayer-location-formatted-address'];
			$c_long = $meta['meta-prayer-location-country-long'];
			$c_short = $meta['meta-prayer-location-country-short'];
			$prayers[$key]->geocode = array(
				'place' => $meta['meta-prayer-location'][0],
				'longitude' => $lon[ sizeof($lon)-1 ],
				'latitude' => $lat[ sizeof($lat)-1 ],
				'formatted' => $add[ sizeof($add)-1 ],
				'c_long' => $c_long[0],
				'c_short' => $c_short[0],
				'lang' => $meta['meta-prayer-lang'][0],
			);

			// set the category data
			$prayers[$key]->category = get_the_terms( $prayer->ID, 'prayer_category' );

			// set the tags data
			$prayers[$key]->tags = get_the_terms( $prayer->ID, 'prayer_tag' );

			// var_dump($prayers[$key]);
		}

		return $prayers;
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
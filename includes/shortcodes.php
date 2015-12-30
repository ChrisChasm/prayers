<?php
/**
 * Shortcodes
 *
 * Provides various shortcodes to be used in templates in the WYSIWYG Editor. 
 * Params the shortcodes take are listed at the beginning of each function. 
 * The shortcodes themselves rely on templates in plugins/echo/templates to 
 * output html code. You can copy these templates to your 
 * themes/your_theme/templates folder and tweak them to your site. 
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

/**
 * Prayers Shortcode
 *
 * Display a listing of prayers based on the attribues you pass. The attribute
 * List is as follows:
 * 
 * - limit='10'
 * - start_date='last_month'
 * - end_date='today'
 *
 * @param  array Custom Attributes
 * @return html
 * @since  0.9.0 
 */
function echo_prayers_shortcode( $atts ) {
	// set shortcode atts to pass to the template
	$shortcode_atts = shortcode_atts(
		array(
			'limit' => '10',
			'start_date' => 'last month',
			'end_date' => 'today',
		), $atts );
	// set var to be accessible in the called template
	set_query_var( 'shortcode_atts', $shortcode_atts );
	// load templates
	$templates = new Echo_Template_Loader;
	// start a buffer to capture output
	ob_start();
	$templates->get_template_part( 'content', 'prayers-listing' );
	return ob_get_clean();
}

/**
 * Prayer Form Shortcode
 *
 * Provides a frontend prayer submission form. This allows frontend users to 
 * submit requests to the prayer app. It currently accepts the following
 * custom attributes:
 *
 * - None at this time
 * 
 * @param  array Custom Attributes
 * @return html
 * @since  0.9.0 
 */
function echo_prayers_form_shortcode( $atts ) {
	// Attributes
	extract( shortcode_atts(
		array(
			'anonymous' => true
		), $atts )
	);
	// load templates
	$templates = new Echo_Template_Loader;
	// start a buffer to capture output
	ob_start();
	$templates->get_template_part( 'content', 'prayers-form' );
	return ob_get_clean();
}

/**
 * Prayer Form Shortcode
 *
 * Provides a frontend prayer map that displays where prayer requests are
 * coming from. It currently accepts the following custom attributes:
 *
 * - None at this time
 * 
 * @param  array Custom Atafsdftributes
 * @return html
 * @since  0.9.0 
 */
function echo_prayers_map_shortcode( $atts ) {
	// Attributes
	extract( shortcode_atts(
		array(

		), $atts)
	);
	// load templates
	$templates = new Echo_Template_Loader;
	// start a buffer to capture output
	ob_start();
	$templates->get_template_part( 'content', 'prayers-map' );
	return ob_get_clean();
}

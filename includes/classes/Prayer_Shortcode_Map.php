<?php
/**
 * Shortcodes
 *
 * Provides various shortcodes to be used in templates in the WYSIWYG Editor. 
 * Params the shortcodes take are listed at the beginning of each function. 
 * The shortcodes themselves rely on templates in plugins/prayer/templates to 
 * output html code. You can copy these templates to your 
 * themes/your_theme/templates folder and tweak them to your site. 
 * 
 * @package   Prayer
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/prayer
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */
class Prayer_Shortcode_Map
{
	static $add_script;

	/**
	 * Initialize Script
	 * @since 0.9.0
	 */
	static function init() 
	{
		add_shortcode( 'prayer_map', array( __CLASS__, 'handle_shortcode' ) );

		add_action( 'init', array( __CLASS__, 'register_script' ) );
		add_action( 'wp_footer', array( __CLASS__, 'print_script' ) ); 
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
	static function handle_shortcode( $atts ) 
	{
		self::$add_script = true;

		// Attributes
		extract( shortcode_atts(
			array(

			), $atts)
		);
		// load templates
		$templates = new Prayer_Template_Loader;
		// start a buffer to capture output
		ob_start();
		$templates->get_template_part( 'content', 'prayers-map' );
		return ob_get_clean();
	}

	static function register_script()
	{
		// register css
		wp_register_style( 'openlayers-css', plugins_url( '/prayer/bower_components/ol3-bower-dist/dist/ol.css', 'prayer' ), array(), null, 'all' );

		// register js
		wp_register_script( 'openlayers-js', plugins_url( '/prayer/bower_components/ol3-bower-dist/dist/ol.js', 'prayer' ), array(), null, 'all' );
		wp_register_script( 'prayer-map-js', plugins_url( '/prayer/js/prayer-map.js', 'prayer' ), array( 'openlayers-js'), '0.9.0', 'all' );
	}

	static function print_script()
	{
		if ( ! self::$add_script ) return;

		// load css
		wp_enqueue_style( 'openlayers-css' );

		// load js
		wp_enqueue_script( 'openlayers-js' );
		wp_enqueue_script( 'prayer-map-js' );
	}
}
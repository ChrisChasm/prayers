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
class Prayer_Shortcode_Form
{
	static $add_script;

	/**
	 * Initialize Script
	 * @since 0.9.0
	 */
	static function init() 
	{
		add_shortcode( 'prayer_form', array( __CLASS__, 'handle_shortcode' ) );

		add_action( 'init', array( __CLASS__, 'register_script' ) );
		add_action( 'wp_footer', array( __CLASS__, 'print_script' ) ); 
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
	static function handle_shortcode( $atts ) 
	{
		self::$add_script = true;

		// Attributes
		extract( shortcode_atts(
			array(
				'anonymous' => true
			), $atts )
		);
		// load templates
		$templates = new Prayer_Template_Loader;
		// start a buffer to capture output
		ob_start();
		$templates->get_template_part( 'content', 'prayers-form' );
		return ob_get_clean();

	}

	static function register_script()
	{
		// register js
		wp_register_script( 'jquery-validation', plugins_url( '/prayer/elements/css/jquery.validate.min.js', 'prayer' ), array( 'jquery' ) );
		wp_register_script( 'jquery-validation-extras', plugins_url( '/prayer/elements/css/additional-methods.min.js', 'prayer' ), array( 'jquery' ) );
		wp_register_script( 'prayer-form-js', plugins_url( '/prayer/elements/js/prayer-form.js', 'prayer' ), array( 'jquery' ), '0.9.0', 'all' );
	}

	static function print_script()
	{
		if ( ! self::$add_script ) return;

		// load js
		wp_print_scripts( 'jquery-validation' );
		wp_print_scripts( 'jquery-validation-extras' );
		wp_print_scripts( 'prayer-form-js' );
	}
}
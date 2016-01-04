<?php
/**
 * Enqueue Frontend Styles and Scripts
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

class Echo_Frontend_Scripts 
{
	/**
	 * Class Construct
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'echo_register_scripts' ) );
	}

	/**
	 * Register Frontend Styles and Scripts
	 * @since  0.9.0
	 */
	public function echo_register_scripts() {

		// styles
		wp_register_style( 'echo-css', plugins_url( '/echo/css/echo.css', 'echo' ), array(), '20151228', 'all' );
		wp_enqueue_style( 'echo-css');

		// load colors
		// get echo options
		$echo_options = get_option( 'echo_settings_options' );
		$button_primary_color = $echo_options['button_primary_color'];
		$button_secondary_color = $echo_options['button_secondary_color'];
		$button_text_color = $echo_options['button_text_color'];
		$taxonomy_background_color = $echo_options['taxonomy_background_color'];
		$taxonomy_text_color = $echo_options['taxonomy_text_color'];
		ob_start();
		?>
	span.echo-pray-button input[type="submit"] {
		background: <?php echo $button_primary_color ?>;
		color: <?php echo $button_text_color ?>;
	}
	span.echo-pray-button:hover input[type="submit"],
	span.echo-pray-button form.prayed-for input[type="submit"]  {
		background: <?php echo $button_secondary_color ?>;
		color: <?php echo $button_text_color ?>;
	}
	span.echo-prayer-count,
	span.echo-box {
		background: <?php echo $taxonomy_background_color; ?>;
		color: <?php echo $taxonomy_text_color; ?>;
	}<?php
		$custom_css = ob_get_clean();
		wp_add_inline_style( 'echo-css', $custom_css );

		// scripts
		wp_register_script( 'jquery-validation', plugins_url( '/echo/bower_components/jquery-validation/dist/jquery.validate.min.js', 'echo' ), array( 'jquery' ) );
		wp_register_script( 'jquery-validation-extras', plugins_url( '/echo/bower_components/jquery-validation/dist/additional-methods.min.js', 'echo' ), array( 'jquery' ) );
		wp_register_script( 'echo-js', plugins_url( '/echo/js/echo.js', 'echo' ), array( 'jquery' ), '20160101', 'all' );

		wp_enqueue_script( 'jquery-validation' );
		wp_enqueue_script( 'jquery-validation-extras' );
		wp_enqueue_script( 'echo-js');	
	}

}

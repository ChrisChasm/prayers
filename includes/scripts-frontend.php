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

/**
 * Register Frontend Styles and Scripts
 * @since  0.9.0
 */
function echo_register_styles() {
	// styles
	wp_register_style( 'echo-css', plugins_url( '/echo/css/echo.css', dir(__FILE__) ), array(), '20151228', 'all' );
	wp_enqueue_style( 'echo-css');
	// scripts
	wp_register_script( 'echo-js', plugins_url( '/echo/js/echo.js', dir(__FILE__) ), array(), '20151228', 'all' );
	wp_enqueue_script( 'echo-js');	
}

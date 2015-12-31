<?php
/**
 * Enqueue Admin Styles and Scripts
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

/**
 * Register Admin Styles and Scripts
 * @since  0.9.0
 */
function echo_register_admin_styles() {
	// styles	
	wp_enqueue_style( 'wp-color-picker' );
	wp_register_style( 'echo-admin-css', plugins_url( '/echo/css/echo-admin.css', dir(__FILE__) ), array(), '20151228', 'all' );
	wp_enqueue_style( 'echo-admin-css');
	// scripts
	wp_register_script( 'echo-admin-js', plugins_url( '/echo/js/echo-admin.js', dir(__FILE__) ), array( 'wp-color-picker' ), '20151228', 'all' );
	wp_enqueue_script( 'echo-admin-js');	
}

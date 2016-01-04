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

class Echo_Admin_Scripts 
{
	/**
	 * Class Construct
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	}

	/**
	 * Register Admin Styles and Scripts
	 * @since  0.9.0
	 */
	function register_admin_scripts() {
		// styles	
		wp_enqueue_style( 'wp-color-picker' );
		wp_register_style( 'echo-admin-css', plugins_url( '/echo/css/echo-admin.css', 'echo' ), array(), '20151228', 'all' );
		wp_enqueue_style( 'echo-admin-css');
		// scripts
		wp_register_script( 'echo-admin-js', plugins_url( '/echo/js/echo-admin.js', 'echo' ), array( 'wp-color-picker' ), '20151228', 'all' );
		wp_enqueue_script( 'echo-admin-js');	
	}
}
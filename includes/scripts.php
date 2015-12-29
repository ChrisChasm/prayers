<?php

// enqueue styles and scripts
function echo_register_styles() {
	
	wp_register_style( 'echo-css', plugins_url( '/echo/css/echo.css', dir(__FILE__) ), array(), '20151228', 'all' );
	wp_enqueue_style( 'echo-css');

	wp_register_script( 'echo-js', plugins_url( '/echo/js/echo.js', dir(__FILE__) ), array(), '20151228', 'all' );
	wp_enqueue_script( 'echo-js');	
}

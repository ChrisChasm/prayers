<?php

// enqueue styles and scripts
function echo_register_admin_styles() {
	
	if ((isset($_GET['post_type']) && $_GET['post_type'] == 'prayer') || (isset($post_type) && $post_type == 'prayer')) :

		wp_register_style( 'echo-admin-css', plugins_url( '/echo/css/echo-admin.css', dir(__FILE__) ), array(), '20151228', 'all' );
		wp_enqueue_style( 'echo-admin-css');

		wp_register_script( 'echo-admin-js', plugins_url( '/echo/js/echo-admin.js', dir(__FILE__) ), array(), '20151228', 'all' );
		wp_enqueue_script( 'echo-admin-js');	

	endif;

}

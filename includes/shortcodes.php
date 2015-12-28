<?php

// Add Shortcode
function prayers_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'count' => '10',
			'start_date' => 'last month',
			'end_date' => 'today',
		), $atts )
	);

	// load templates
	$templates = new Echo_Template_Loader;

	// start a buffer to capture output
	ob_start();
	$templates->get_template_part( 'content', 'prayers' );
	return ob_get_clean();
}

add_shortcode( 'prayers', 'prayers_shortcode' );

function prayers_form( $atts ) {
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

add_shortcode( 'prayers_form', 'prayers_form' );
<?php
/**
 * Echo Settings Page
 *
 * Creates a settings page for the plugin. Allows setting options like colors
 * enabling/disabling features, etc.
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

/**
 * Add Settings to Admin Menu
 * @return hook
 * @since  0.9.0
 */
function echo_add_admin_menu(  ) { 
	add_submenu_page( 'edit.php?post_type=prayer', 'Settings', 'Settings', 'manage_options', 'echo', 'echo_options_page' );
	//add_menu_page( 'Echo', 'Echo', 'manage_options', 'echo', 'echo_options_page' );
}

/**
 * Initialize Settings
 * @since  0.9.0 
 */
function echo_settings_init(  ) { 

	register_setting( 'pluginPage', 'echo_settings' );

	// Color Settings Description
	add_settings_section(
		'echo_color_section', 
		__( 'Color Settings', 'echo' ), 
		'echo_settings_color_section_callback', 
		'pluginPage'
	);
	// Primary Color
	add_settings_field( 
		'echo_primary_color', 
		__( 'Primary Color', 'echo' ), 
		'echo_primary_color_render', 
		'pluginPage', 
		'echo_color_section' 
	);
	// Secondary Color
	add_settings_field( 
		'echo_secondary_color', 
		__( 'Secondary Color', 'echo' ), 
		'echo_secondary_color_render', 
		'pluginPage', 
		'echo_color_section' 
	);

	// MailChimp Settings Description
	add_settings_section(
		'echo_mailchimp_section', 
		__( 'MailChimp Settings', 'echo' ), 
		'echo_settings_mailchimp_section_callback', 
		'pluginPage'
	);
	// MailChimp API key
	add_settings_field( 
		'echo_mailchimp_api_key', 
		__( 'MailChimp API Key', 'echo' ), 
		'echo_mailchimp_api_key_render', 
		'pluginPage', 
		'echo_mailchimp_section' 
	);
	

	




	add_settings_field( 
		'echo_checkbox_field_1', 
		__( 'Settings field description', 'echo' ), 
		'echo_checkbox_field_1_render', 
		'pluginPage', 
		'echo_pluginPage_section' 
	);

	add_settings_field( 
		'echo_radio_field_2', 
		__( 'Settings field description', 'echo' ), 
		'echo_radio_field_2_render', 
		'pluginPage', 
		'echo_pluginPage_section' 
	);

	add_settings_field( 
		'echo_textarea_field_3', 
		__( 'Settings field description', 'echo' ), 
		'echo_textarea_field_3_render', 
		'pluginPage', 
		'echo_pluginPage_section' 
	);

	add_settings_field( 
		'echo_select_field_4', 
		__( 'Settings field description', 'echo' ), 
		'echo_select_field_4_render', 
		'pluginPage', 
		'echo_pluginPage_section' 
	);


}

/**
 * Color Section
 */
function echo_settings_color_section_callback(  ) { 

	echo __( 'Choose a primary and secondary color.', 'echo' );

}

/**
 * Primary Color Render
 */
function echo_primary_color_render(  ) { 

	$options = get_option( 'echo_settings' );
	?>
	<input type='text' name='echo_settings[echo_primary_color]' value='<?php echo $options['echo_primary_color']; ?>'>
	<?php

}

/**
 * Secondary Color Render
 */
function echo_secondary_color_render(  ) { 

	$options = get_option( 'echo_settings' );
	?>
	<input type='text' name='echo_settings[echo_secondary_color]' value='<?php echo $options['echo_secondary_color']; ?>'>
	<?php

}

/**
 * MailChimp Section
 */
function echo_settings_mailchimp_section_callback(  ) { 

	echo __( 'Enter a MailChimp API key.', 'echo' );

}

/**
 * MailChimp API Key
 */
function echo_mailchimp_api_key_render(  ) { 

	$options = get_option( 'echo_settings' );
	?>
	<input type='text' name='echo_settings[echo_secondary_color]' value='<?php echo $options['echo_secondary_color']; ?>'>
	<?php

}


function echo_checkbox_field_1_render(  ) { 

	$options = get_option( 'echo_settings' );
	?>
	<input type='checkbox' name='echo_settings[echo_checkbox_field_1]' <?php checked( $options['echo_checkbox_field_1'], 1 ); ?> value='1'>
	<?php

}


function echo_radio_field_2_render(  ) { 

	$options = get_option( 'echo_settings' );
	?>
	<input type='radio' name='echo_settings[echo_radio_field_2]' <?php checked( $options['echo_radio_field_2'], 1 ); ?> value='1'>
	<?php

}


function echo_textarea_field_3_render(  ) { 

	$options = get_option( 'echo_settings' );
	?>
	<textarea cols='40' rows='5' name='echo_settings[echo_textarea_field_3]'> 
		<?php echo $options['echo_textarea_field_3']; ?>
 	</textarea>
	<?php

}


function echo_select_field_4_render(  ) { 

	$options = get_option( 'echo_settings' );
	?>
	<select name='echo_settings[echo_select_field_4]'>
		<option value='1' <?php selected( $options['echo_select_field_4'], 1 ); ?>>Option 1</option>
		<option value='2' <?php selected( $options['echo_select_field_4'], 2 ); ?>>Option 2</option>
	</select>

<?php

}

/**
 * Echo Settings Page HTML
 * @return html
 * @since  0.9.0 
 */
function echo_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
		
		<h2>Echo Prayers Settings</h2>
		
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
		
	</form>
	<?php

}

?>
<?php
/**
 * Prayer Settings
 *
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 *
 * @package   Prayer
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/prayer
 * @copyright 2016 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

class Prayer_Settings {

	private $prayer_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'prayer_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'prayer_settings_page_init' ) );
	}

	public function prayer_settings_add_plugin_page() {
		add_submenu_page(
	        'edit.php?post_type=prayer',
	        'Prayer Settings',
	        'Settings',
	        'edit_posts',
	        'settings',
	        array( $this, 'prayer_settings_create_admin_page' )
	    );
	}

	public function prayer_settings_create_admin_page() {
		$this->prayer_settings_options = get_option( 'prayer_settings_options' ); ?>

		<div class="wrap">
			<h2>Prayer Settings</h2>
			<p>Adjust Prayer to fit your website. For documentation visit <a href="https://github.com/kalebheitzman/prayers/blob/master/documentation.md" target="_blank">documentation.md</a> on our github <a href="https://github.com/kalebheitzman/prayer" target="_blank">project page.</a></p>

			<?php settings_errors(); ?>

			<h2><a href="http://kheitzman.com" target="_blank" class="kh-credits">KH</a></h2>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'prayer_settings_option_group' );
					do_settings_sections( 'prayer-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function prayer_settings_page_init() {
		register_setting(
			'prayer_settings_option_group', // option_group
			'prayer_settings_options', // option_name
			array( $this, 'prayer_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'prayer_settings_setting_section', // id
			'Settings', // title
			array( $this, 'prayer_settings_section_info' ), // callback
			'prayer-settings-admin' // page
		);

		add_settings_field(
			'notification_user', // id
			'User Notifications', // title
			array( $this, 'notification_user_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field(
			'mailchimp_api_key', // id
			'MailChimp API Key', // title
			array( $this, 'mailchimp_api_key_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field(
			'mailchimp_magic', // id
			'MailChimp Magic', // title
			array( $this, 'mailchimp_magic_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field(
			'prayer_form_response', // id
			'Prayer Form Response', // title
			array( $this, 'prayer_form_response_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field( // #2582EA
			'button_primary_color', // id
			'Button Background Color', // title
			array( $this, 'button_primary_color_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field( // #45D680
			'button_secondary_color', // id
			'Button Active Background Color', // title
			array( $this, 'button_secondary_color_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field( // #fff
			'button_text_color', // id
			'Button Text Color', // title
			array( $this, 'button_text_color_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field( // #efefef
			'taxonomy_text_color', // id
			'Taxonomy Text Color', // title
			array( $this, 'taxonomy_text_color_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field( // #333
			'taxonomy_background_color', // id
			'Taxonomy Background Color', // title
			array( $this, 'taxonomy_background_color_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field(
			'location_enabled', // id
			'Location Enabled', // title
			array( $this, 'location_enabled_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field(
			'categories_enabled', // id
			'Categories Enabled', // title
			array( $this, 'categories_enabled_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		add_settings_field(
			'tags_enabled', // id
			'Tags Enabled', // title
			array( $this, 'tags_enabled_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);

		/*add_settings_field(
			'default_category', // id
			'Default Category', // title
			array( $this, 'default_category_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);*/

		/*add_settings_field(
			'example_radio', // id
			'Example Radio', // title
			array( $this, 'example_radio_callback' ), // callback
			'prayer-settings-admin', // page
			'prayer_settings_setting_section' // section
		);*/
	}

	public function prayer_settings_sanitize($input) {
		$sanitary_values = array();

		if ( isset( $input['notification_user'] ) ) {
			$sanitary_values['notification_user'] = sanitize_text_field( $input['notification_user'] );
		}

		if ( isset( $input['mailchimp_api_key'] ) ) {
			$sanitary_values['mailchimp_api_key'] = sanitize_text_field( $input['mailchimp_api_key'] );
		}

		if ( isset( $input['button_primary_color'] ) ) {
			$sanitary_values['button_primary_color'] = sanitize_text_field( $input['button_primary_color'] );
		}

		if ( isset( $input['button_secondary_color'] ) ) {
			$sanitary_values['button_secondary_color'] = sanitize_text_field( $input['button_secondary_color'] );
		}

		if ( isset( $input['button_text_color'] ) ) {
			$sanitary_values['button_text_color'] = sanitize_text_field( $input['button_text_color'] );
		}

		if ( isset( $input['taxonomy_background_color'] ) ) {
			$sanitary_values['taxonomy_background_color'] = sanitize_text_field( $input['taxonomy_background_color'] );
		}

		if ( isset( $input['taxonomy_text_color'] ) ) {
			$sanitary_values['taxonomy_text_color'] = sanitize_text_field( $input['taxonomy_text_color'] );
		}

		if ( isset( $input['location_enabled'] ) ) {
			$sanitary_values['location_enabled'] = $input['location_enabled'];
		}

		if ( isset( $input['categories_enabled'] ) ) {
			$sanitary_values['categories_enabled'] = $input['categories_enabled'];
		}

		if ( isset( $input['tags_enabled'] ) ) {
			$sanitary_values['tags_enabled'] = $input['tags_enabled'];
		}

		if ( isset( $input['mailchimp_magic_enabled'] ) ) {
			$sanitary_values['mailchimp_magic_enabled'] = $input['mailchimp_magic_enabled'];
		}

		if ( isset( $input['default_category'] ) ) {
			$sanitary_values['default_category'] = $input['default_category'];
		}

		if ( isset( $input['prayer_form_response'] ) ) {
			$sanitary_values['prayer_form_response'] = wp_kses( $input['prayer_form_response'], array() );
		}

		if ( isset( $input['example_radio'] ) ) {
			$sanitary_values['example_radio'] = $input['example_radio'];
		}

		return $sanitary_values;
	}

	public function prayer_settings_section_info() {

	}

	/*public function notification_email_callback() {
		printf(
			'<input class="regular-text" type="text" name="prayer_settings_options[notification_email]" id="notification_email" value="%s" placeholder="prayer@example.com">',
			isset( $this->prayer_settings_options['notification_email'] ) ? esc_attr( $this->prayer_settings_options['notification_email']) : ''
		);
	}*/

	public function notification_user_callback() {
		$args = array(
			'name' => 'prayer_settings_options[notification_user]',
			'id' => 'notification_user',
			'selected' => $this->prayer_settings_options['notification_user'],
		);
		wp_dropdown_users( $args );
		echo ' <small>' . __( 'User that is notified by email when a new prayer request is submitted.', 'prayer' ) . '</small>';
		?>
		<?php
	}

	public function mailchimp_api_key_callback() {
		printf(
			'<input class="regular-text" type="text" name="prayer_settings_options[mailchimp_api_key]" id="mailchimp_api_key" value="%s">',
			isset( $this->prayer_settings_options['mailchimp_api_key'] ) ? esc_attr( $this->prayer_settings_options['mailchimp_api_key']) : ''
		);
		echo '<span> <a href="http://admin.mailchimp.com/account/api/" target="_blank">Get a MailChimp API Key</a></span>';
	}

	public function mailchimp_magic_callback() {
		?> <fieldset class="prayer-inline-radios"><?php $checked = ( isset( $this->prayer_settings_options['mailchimp_magic_enabled'] ) && $this->prayer_settings_options['mailchimp_magic_enabled'] === '1' ) ? 'checked' : '' ; ?>
		<label for="mailchimp_magic_enabled-0"><input type="radio" name="prayer_settings_options[mailchimp_magic_enabled]" id="mailchimp_magic_enabled-0" value="1" <?php echo $checked; ?>> Yes</label>
		<?php $checked = ( isset( $this->prayer_settings_options['mailchimp_magic_enabled'] ) && $this->prayer_settings_options['mailchimp_magic_enabled'] === '0' ) ? 'checked' : '' ; ?>
		<label for="mailchimp_magic_enabled-1"><input type="radio" name="prayer_settings_options[mailchimp_magic_enabled]" id="mailchimp_magic_enabled-1" value="0" <?php echo $checked; ?>> No</label>
		<?php echo '<small>' . __( 'Sync MailChimp Subscriber info to prayer requests in WordPress? (experimental)', 'prayer' ) . '</small>'; ?>
		</fieldset> <?php
	}

	public function button_primary_color_callback() {
		printf(
			'<input class="regular-text color-field" type="text" name="prayer_settings_options[button_primary_color]" id="button_primary_color" value="%s">',
			isset( $this->prayer_settings_options['button_primary_color'] ) ? esc_attr( $this->prayer_settings_options['button_primary_color']) : '#2582EA'
		);
		echo ' <small>' . __( 'Color of prayer button.', 'prayer' ) . '</small>';
	}

	public function button_secondary_color_callback() {
		printf(
			'<input class="regular-text color-field" type="text" name="prayer_settings_options[button_secondary_color]" id="button_secondary_color" value="%s">',
			isset( $this->prayer_settings_options['button_secondary_color'] ) ? esc_attr( $this->prayer_settings_options['button_secondary_color']) : '#45D680'
		);
		echo ' <small>' . __( 'Color of highlighted prayer button.', 'prayer' ) . '</small>';
	}

	public function button_text_color_callback() {
		printf(
			'<input class="regular-text color-field" type="text" name="prayer_settings_options[button_text_color]" id="button_text_color" value="%s">',
			isset( $this->prayer_settings_options['button_text_color'] ) ? esc_attr( $this->prayer_settings_options['button_text_color']) : '#fff'
		);
		echo ' <small>' . __( 'Text color of prayer button.', 'prayer' ) . '</small>';
	}

	public function taxonomy_background_color_callback() {
		printf(
			'<input class="regular-text color-field" type="text" name="prayer_settings_options[taxonomy_background_color]" id="taxonomy_background_color" value="%s">',
			isset( $this->prayer_settings_options['taxonomy_background_color'] ) ? esc_attr( $this->prayer_settings_options['taxonomy_background_color']) : '#efefef'
		);
		echo ' <small>' . __( 'Text color of taxonomy pill.', 'prayer' ) . '</small>';
	}

	public function taxonomy_text_color_callback() {
		printf(
			'<input class="regular-text color-field" type="text" name="prayer_settings_options[taxonomy_text_color]" id="taxonomy_text_color" value="%s">',
			isset( $this->prayer_settings_options['taxonomy_text_color'] ) ? esc_attr( $this->prayer_settings_options['taxonomy_text_color']) : '#333'
		);
		echo ' <small>' . __( 'Text color of taxonomy pill.', 'prayer' ) . '</small>';
	}

	public function location_enabled_callback() {
		?> <fieldset class="prayer-inline-radios"><?php $checked = ( isset( $this->prayer_settings_options['location_enabled'] ) && $this->prayer_settings_options['location_enabled'] === '1' ) ? 'checked' : '' ; ?>
		<label for="location_enabled-0"><input type="radio" name="prayer_settings_options[location_enabled]" id="location_enabled-0" value="1" <?php echo $checked; ?>> Yes</label>
		<?php $checked = ( isset( $this->prayer_settings_options['location_enabled'] ) && $this->prayer_settings_options['location_enabled'] === '0' ) ? 'checked' : '' ; ?>
		<label for="location_enabled-1"><input type="radio" name="prayer_settings_options[location_enabled]" id="location_enabled-1" value="0" <?php echo $checked; ?>> No</label>
		<?php echo '<small>' . __( 'Enable frontend users to enter a location for thier prayer request?', 'prayer' ) . '</small>'; ?>
		</fieldset> <?php

	}

	public function categories_enabled_callback() {
		?> <fieldset class="prayer-inline-radios"><?php $checked = ( isset( $this->prayer_settings_options['categories_enabled'] ) && $this->prayer_settings_options['categories_enabled'] === '1' ) ? 'checked' : '' ; ?>
		<label for="categories_enabled-0"><input type="radio" name="prayer_settings_options[categories_enabled]" id="categories_enabled-0" value="1" <?php echo $checked; ?>> Yes</label>
		<?php $checked = ( isset( $this->prayer_settings_options['categories_enabled'] ) && $this->prayer_settings_options['categories_enabled'] === '0' ) ? 'checked' : '' ; ?>
		<label for="categories_enabled-1"><input type="radio" name="prayer_settings_options[categories_enabled]" id="categories_enabled-1" value="0" <?php echo $checked; ?>> No</label>
		<?php echo '<small>' . __( 'Enable frontend users to select a category for thier prayer request?', 'prayer' ) . '</small>'; ?>
		</fieldset> <?php

	}

	public function tags_enabled_callback() {
		?> <fieldset class="prayer-inline-radios"><?php $checked = ( isset( $this->prayer_settings_options['tags_enabled'] ) && $this->prayer_settings_options['tags_enabled'] === '1' ) ? 'checked' : '' ; ?>
		<label for="tags_enabled-0"><input type="radio" name="prayer_settings_options[tags_enabled]" id="tags_enabled-0" value="1" <?php echo $checked; ?>> Yes</label>
		<?php $checked = ( isset( $this->prayer_settings_options['tags_enabled'] ) && $this->prayer_settings_options['tags_enabled'] === '0' ) ? 'checked' : '' ; ?>
		<label for="tags_enabled-1"><input type="radio" name="prayer_settings_options[tags_enabled]" id="tags_enabled-1" value="0" <?php echo $checked; ?>> No</label>
		<?php echo '<small>' . __( 'Enable frontend users to tag thier prayer request?', 'prayer' ) . '</small>'; ?>
		</fieldset> <?php
	}

	public function default_category_callback() {
		?> <select name="prayer_settings_options[default_category]" id="default_category">
			<?php $selected = (isset( $this->prayer_settings_options['default_category'] ) && $this->prayer_settings_options['default_category'] === '1') ? 'selected' : '' ; ?>
			<option value="1" <?php echo $selected; ?>>Yes</option>
			<?php $selected = (isset( $this->prayer_settings_options['default_category'] ) && $this->prayer_settings_options['default_category'] === '0') ? 'selected' : '' ; ?>
			<option value="0" <?php echo $selected; ?>>No</option>
		</select> <?php
	}

	public function prayer_form_response_callback() {
		$content = isset( $this->prayer_settings_options['prayer_form_response'] ) ? $this->prayer_settings_options['prayer_form_response'] : '';
		$settings = array(
			'textarea_name' => 'prayer_settings_options[prayer_form_response]',
			'textarea_rows' => 8,
			'media_buttons' => false,
		);
		wp_editor( $content, 'prayer_form_response', $settings );
	}

	public function example_radio_callback() {
		?> <fieldset><?php $checked = ( isset( $this->prayer_settings_options['example_radio'] ) && $this->prayer_settings_options['example_radio'] === '1' ) ? 'checked' : '' ; ?>
		<label for="example_radio-0"><input type="radio" name="prayer_settings_options[example_radio]" id="example_radio-0" value="1" <?php echo $checked; ?>> Yes</label><br>
		<?php $checked = ( isset( $this->prayer_settings_options['example_radio'] ) && $this->prayer_settings_options['example_radio'] === '0' ) ? 'checked' : '' ; ?>
		<label for="example_radio-1"><input type="radio" name="prayer_settings_options[example_radio]" id="example_radio-1" value="0" <?php echo $checked; ?>> No</label></fieldset> <?php
	}

}

/*
 * Retrieve this value with:
 * $prayer_settings_options = get_option( 'prayer_settings_options' ); // Array of All Options
 * $notification_email = $prayer_settings_options['notification_email']; // Notification Email
 * $notification_user = $prayer_settings_options['notification_user']; // Notification User
 * $mailchimp_api_key = $prayer_settings_options['mailchimp_api_key']; // MailChimp API Key
 * $button_primary_color = $prayer_settings_options['button_primary_color']; // Primary Color
 * $button_secondary_color = $prayer_settings_options['button_secondary_color']; // Secondary Color
 * $categories_enabled = $prayer_settings_options['categories_enabled']; // Categories Enabled
 * $tags_enabled = $prayer_settings_options['tags_enabled']; // Tags Enabled
 * $default_category = $prayer_settings_options['default_category']; // Default Category
 * $prayer_form_response = $prayer_settings_options['prayer_form_response']; // Example Textarea
 * $example_radio = $prayer_settings_options['example_radio']; // Example Radio
 */

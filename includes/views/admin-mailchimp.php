<h2>MailChimp</h2>

<?php
	$settings = get_option( 'prayer_settings_options' );
	$api_key = $settings['mailchimp_api_key'];

	if ( empty( $api_key ) ): 
	// display a message telling the user to update thier key
		?>
		<p>Please enter a MailChimp API Key on the <a href="<?php echo get_site_url() ?>/wp-admin/edit.php?post_type=prayer&amp;page=settings">Prayer Settings page.</a></p>
	<?php else: 
	// display the mailchimp integration page
	?>

		<p>Sync a <a href="http://mailchimp.com" target="_blank">MailChimp</a> list and pre-defined segments from people who have
submitted prayer requests on your website.</p>
	
	<?php endif; ?>
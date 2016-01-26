<div id="prayer-navigation" class="prayer-navigation">

	<h2 class="nav-tab-wrapper current">
		<a class="nav-tab nav-tab-active" href="javascript:;"><?php echo __( 'Notes', 'prayer' ) ?></a>
		<a class="nav-tab" href="javascript:;"><?php echo __( 'Response', 'prayer' ) ?></a>
		<a class="nav-tab" href="javascript:;"><?php echo __( 'Geolocation', 'prayer' ) ?></a>
		<a class="nav-tab" href="javascript:;"><?php echo __( 'Contact', 'prayer' ) ?></a>
		<?php // get mailchimp
			$mc = new Prayer_Mailchimp;
			if ( ! empty( $mc->mc_api->apikey ) ): ?>
			<a class="nav-tab" href="javascript:;"><?php echo __( 'MailChimp', 'prayer' ) ?></a>
		<?php endif; ?>
		<a class="nav-tab" href="javascript:;"><?php echo __( 'Meta', 'prayer' ) ?></a>
	</h2>

	<?php
		// get user notes
		include ( 'partials/meta-notes.php' );
		// prayer answered response
		include ( 'partials/meta-responses.php' );
		// geolocation data
		include ( 'partials/meta-geolocation.php' );
		// contact information
		include ( 'partials/meta-contact.php' );
		// mailchimp if enabled
		if ( ! empty( $mc->mc_api->apikey ) ):
			include ( 'partials/meta-mailchimp.php' );
		endif;
		// general meta
		include ( 'partials/meta-processing.php' );

		// Add a nonce field for security
        wp_nonce_field( 'prayer_save', 'prayer_nonce' );
	?>

</div>

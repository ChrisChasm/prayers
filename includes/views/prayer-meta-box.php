<div id="prayer-navigation">
	
	<h2 class="nav-tab-wrapper current">
		<a class="nav-tab nav-tab-active" href="javascript:;"><?php echo __( 'Notes', 'prayer' ) ?></a>
		<a class="nav-tab" href="javascript:;"><?php echo __( 'Geolocation', 'prayer' ) ?></a>
		<a class="nav-tab" href="javascript:;"><?php echo __( 'Details', 'prayer' ) ?></a>
	</h2>

	<?php
		include ( 'partials/meta-notes.php' );
		include ( 'partials/meta-geolocation.php' );
		include ( 'partials/meta-details.php' ); 
	?>
	
</div>

<input type="hidden" name="prayer_nonce" value="<?php echo wp_create_nonce( 'prayer-nonce' ); ?>" />

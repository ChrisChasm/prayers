<?php
// prayer navigation
Prayer_Template_Helper::get_navigation();

// show flash messages
Prayer_Template_Helper::flash_message();

?><form method="post" id="prayer-form" class="prayer form prayer-js" action="">
	<?php wp_nonce_field( basename(__FILE__), 'prayer_nonce' ); ?>

	<p class="prayer-email">
		<label for="prayer_email" class="hide"><?php echo __('Your email address', 'prayer') ?></label>
		<input type="email" name="prayer_email" minlength="6" required placeholder="Your email address (required)" />
		<input type="hidden" name="prayer-send-token" value="1" />
		<input type="submit" value="Send link" />
	</p>

</form>
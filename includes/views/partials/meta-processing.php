<div class="inside hidden">

	<div class="column"><?php
		// answered value
		$anonymous = $post_meta['prayer-anonymous'][0];
		if (empty($anonymous)) {
			$anonymous = false;
		}
		// build the anonymouse radio buttons
		$anonymousTrue = $anonymous == true ? 'checked' : '';
		$anonymousFalse = $anonymous == false ? 'checked' : '';
		?>
		<p>
			<label for="prayer-anonymous"><?php echo __('Anonymous?', 'prayer') ?></label>
			<label><input type="radio" name="prayer-anonymous" value="0" <?php echo $anonymousFalse; ?> /><span>No </span></label>
			<label><input type="radio" name="prayer-anonymous" value="1" <?php echo $anonymousTrue; ?> /><span>Yes </span></label>
		</p>

		<?php // build the answered radio buttons
		$answered = $post_meta['prayer-answered'][0];

		if (empty($answered)) {
			$answered = false;
		}
		$answeredTrue = $answered == true ? 'checked' : '';
		$answeredFalse = $answered == false ? 'checked' : '';

		?>
		<p>
			<label for="prayer-answered"><?php echo __('Answered?', 'prayer') ?> </label>
			<label><input type="radio" name="prayer-answered" value="0" <?php echo $answeredFalse; ?> /><span>No </span></label>
			<label><input type="radio" name="prayer-answered" value="1" <?php echo $answeredTrue; ?> /><span>Yes </span></label>
		</p>
	</div><!--.column-->

	<div class="column">
		<?php // build the prayed_for radio buttons
		$prayer_prayed = $post_meta['prayer-prayed'][0];
		if ( $prayer_prayed == "1" ) {
			$prayed_checked = 'checked="checked"';
		}
		?>
		<p>
			<label><input type="checkbox"e name="prayer-prayed" value="1" <?php echo $prayed_checked; ?> /><span><?php echo __( 'Prayed for?', 'prayer' ) ?></span></label>
		</p>

		<?php // build the prayed_for radio buttons
		$prayer_email_sent = $post_meta['prayer-email-sent'][0];
		if ( $prayer_email_sent == "1" ) {
			$email_sent_checked = 'checked="checked"';
		}
		?>
		<p>
			<label><input type="checkbox" name="prayer-email-sent" value="1" <?php echo $email_sent_checked ?>><?php echo __( 'Email sent?', 'prayer' ) ?></inpu>
		</p>
	</div><!--.column-->

	<div class="column"><?php // build the prayer count input
			$count = $post_meta['prayer-count'][0];
		?>
		<p>
			<label for="prayer-count"><?php echo __('Prayed Count', 'prayer') ?></label>
			<input type="text" name="prayer-count" value="<?php echo $count; ?>" size="7" />
		</p>
	</div><!--.column-->

</div>
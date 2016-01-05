<div class="inside hidden"><?php

	// answered value
	$anonymous = $post_meta['meta-prayer-anonymous'][0];
	if (empty($anonymous)) {
		$anonymous = false;
	}
	// build the anonymouse radio buttons
	$anonymousTrue = $anonymous == true ? 'checked' : '';
	$anonymousFalse = $anonymous == false ? 'checked' : '';
	?>
	<p>
		<label for="meta-prayer-anonymous"><?php echo __('Anonymous?', 'prayer') ?></label>
		<label><input type="radio" name="meta-prayer-anonymous" value="0" <?php echo $anonymousFalse; ?> /><span>No </span></label>
		<label><input type="radio" name="meta-prayer-anonymous" value="1" <?php echo $anonymousTrue; ?> /><span>Yes </span></label>
	</p>

	<?php // build the answered radio buttons
	$answered = $post_meta['meta-prayer-answered'][0];

	if (empty($answered)) {
		$answered = false;
	}
	$answeredTrue = $answered == true ? 'checked' : '';
	$answeredFalse = $answered == false ? 'checked' : '';

	?>
	<p>
		<label for="meta-prayer-answered"><?php echo __('Answered?', 'prayer') ?> </label>
		<label><input type="radio" name="meta-prayer-answered" value="0" <?php echo $answeredFalse; ?> /><span>No </span></label>
		<label><input type="radio" name="meta-prayer-answered" value="1" <?php echo $answeredTrue; ?> /><span>Yes </span></label>
	</p>

	<?php // build the prayer count input
	$count = $post_meta['meta-prayer-count'][0];
	?>

	<p>
		<label for="meta-prayer-count"><?php echo __('Prayed Count', 'prayer') ?></label>
		<input type="text" name="meta-prayer-count" value="<?php echo $count; ?>" />
	</p>

	<?php // build the submitter name input
	$name = $post_meta['meta-prayer-name'][0];
	?>

	<p><strong>Contact Info</strong></p>

	<p>
		<label for="meta-prayer-name"><?php echo __('Name', 'prayer') ?></label>
		<input type="text" name="meta-prayer-name" value="<?php echo $name; ?>" />
	</p>

	<?php // build the email input
	$email = $post_meta['meta-prayer-email'][0];
	?>

	<p>
		<label for="meta-prayer-email"><?php echo __('Email', 'prayer') ?></label>
		<input type="text" name="meta-prayer-email" value="<?php echo $email; ?>" />
	</p>

	<p><strong>Geolocation Info</strong></p>

	<?php // build the location output
	$location = $post_meta['meta-prayer-location'][0];
	?>

	<p>
		<label for="meta-prayer-location"><?php echo __('Location', 'prayer') ?></label>
		<input type="text" name="meta-prayer-location" value="<?php echo $location; ?>" />
	</p>

	<?php // build the lang output
	$lang = $post_meta['meta-prayer-lang'][0];
	?>

	<p>
		<label for="meta-prayer-lang"><?php echo __('Language', 'prayer') ?></label>
		<input type="text" name="meta-prayer-lang" value="<?php echo $lang; ?>" />
	</p>

	<?php // if location is set, build the geocoded data and display it
	if ( ! empty($location) ):

		$latitude = $post_meta['meta-prayer-location-latitude'][0];
		$longitude = $post_meta['meta-prayer-location-longitude'][0];
		$formatted = $post_meta['meta-prayer-location-formatted-address'][0];
		$long = $post_meta['meta-prayer-location-country-long'][0];
		$short = $post_meta['meta-prayer-location-country-short'][0];	

	?>

	<div>
		<ul class="prayer-geocode">
			<li>Latitude: <?php echo $latitude; ?></li>
			<li>Longitude: <?php echo $longitude; ?></li>
			<li>Address: <?php echo $formatted; ?></li>
			<li>Country: <?php echo $long; ?> (<?php echo $short ?>)</li>
		</ul>
	</div>


	<?php
	endif;

?></div>
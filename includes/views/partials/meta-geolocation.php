<div class="inside hidden">

	<div class="column"><?php
		// answered value
		$mapEnabled = $post_meta['prayer-map-enabled'][0];
		if (empty($mapEnabled)) {
			$mapEnabled = false;
		}
		// build the anonymouse radio buttons
		$mapEnabledTrue = $mapEnabled == true ? 'checked' : '';
		$mapEnabledFalse = $mapEnabled == false ? 'checked' : '';
		?>
		<p>
			<label for="prayer-map-enabled"><?php echo __('Place on map?', 'prayer') ?></label>
			<label><input type="radio" name="prayer-map-enabled" value="0" <?php echo $mapEnabledFalse; ?> /><span>No </span></label>
			<label><input type="radio" name="prayer-map-enabled" value="1" <?php echo $mapEnabledTrue; ?> /><span>Yes </span></label>
		</p>

		<?php // build the location output
		$location = $post_meta['prayer-location'][0];
		?>

		<p>
			<label for="prayer-location"><?php echo __('Location', 'prayer') ?></label>
			<input type="text" name="prayer-location" placeholder="Lexington, KY" value="<?php echo $location; ?>" />
		</p>

		<?php // build the lang output
		$lang = $post_meta['prayer-lang'][0];
		?>

		<p>
			<label for="prayer-lang"><?php echo __('Language', 'prayer') ?></label>
			<input type="text" name="prayer-lang" size="2" placeholder="en" value="<?php echo $lang; ?>" />
		</p>
	</div><!--.column-->

	<div class="column align-right">
		<?php // if location is set, build the geocoded data and display it
		if ( ! empty($location) ):

			$latitude = $post_meta['prayer-location-latitude'][0];
			$longitude = $post_meta['prayer-location-longitude'][0];
			$formatted = $post_meta['prayer-location-formatted-address'][0];
			$long = $post_meta['prayer-location-country-long'][0];
			$short = $post_meta['prayer-location-country-short'][0];

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
		endif; ?>
	</div><!--.column-->

	<div class="column">
		<?php if ( ! empty($location) ): ?>
			<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $latitude ?>,<?php echo $longitude ?>&zoom=11&size=400x150&maptype=roadmap" />
		<?php endif; ?>
	</div><!--.column-->

</div>

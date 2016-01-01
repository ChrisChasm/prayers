<?php 

// get echo options
$echo_options = get_option( 'echo_settings_options' );

if (count($_POST) > 0): 

	// get custom notification
	$response = $echo_options['prayer_form_response'];

	echo wpautop( $response );

	?>
	
	<?php else: ?>
	
	<style type="text/css">
		.prayer-form label.hide { display: none; }
	</style>
		
	<form method="post" id="echo-prayer-form" class="echo form" action="">
		<?php wp_nonce_field( basename(__FILE__), 'prayer_nonce' ); ?>

		<p><strong>Your prayer request</strong></p>

		<p class="prayer-title">
			<label for="prayer_title" class="hide"><?php echo __('Prayer title', 'prayer') ?></label>
			<input type="text" name="prayer_title" placeholder="Prayer title" />
		</p>

		<p class="prayer-content">
			<label for="prayer_content" class="hide"><?php echo __('Prayer Request', 'prayer') ?></label>
			<textarea name="prayer_content" rows="4" placeholder="Please enter your request here..."></textarea>
		</p>

		<p><strong>Your contact information</strong></p>

		<p class="prayer-name">
			<label for="prayer_name" class="hide"><?php echo __('Your name', 'prayer') ?></label>
			<input type="text" name="prayer_name" placeholder="Your name"/>
		</p>

		<p class="prayer-email">
			<label for="prayer_email" class="hide"><?php echo __('Your email', 'prayer') ?></label>
			<input type="text" name="prayer_email" placeholder="Your email" />
		</p>

		<p><strong>Place your request on the map?</strong><br />
		<small>City and state is fine, we don't need a full address.</small></p>

		<p class="prayer-address">
			<label for="prayer_location" class="hide"><?php echo __('Your city, state, province, country', 'prayer') ?></label>
			<input type="text" name="prayer_location" placeholder="Your city, state, province, country, etc (not required)" />
		</p>

		<?php
		// check to see if categories are enabled
		$categories_enabled = $echo_options['categories_enabled'];

		if ($categories_enabled == '1'):
			$prayer_category = array( 'prayer_category' );
			$args = array(
				'orderby' => 'name',
				'order' => 'ASC',
				'hide_empty' => false
			);
			$prayer_categories = get_terms($prayer_category, $args);
		?>

		<p class="prayer-categories inline-form-elements">
			<label for="prayer_category">
				<strong><?php echo __('Categories', 'echo'); ?></strong>
			</label><br />
			<?php foreach ($prayer_categories as $category): ?>
				<label for="<?php echo $category->slug; ?>">
					<input type="radio" name="prayer_category" value="<?php echo $category->slug; ?>" /> <?php echo $category->name ?> &nbsp;
				</label>
			<?php endforeach; ?>
		</p>

		<?php endif; // categories enabled

		// check to see if tags are enabled
		$tags_enabled = $echo_options['tags_enabled'];
		if ( $tags_enabled == '1' ):

		?>

		<p class="prayer-tags">
			<label for="prayer_tags">
				<strong><?php echo __('Tags', 'echo'); ?></strong>
				<input type="text" name="prayer_tags" value="" placeholder="healing, doctors, africa" />
			</label>
			<small>Comma-separated list of tags for your request</small>
		</p>

		<?php endif; // tags enabled ?>
		
		<p class="prayer-anonymous inline-form-elements">
			<label>
				<strong><?php echo __('Would you like this prayer request to be anonymous?', 'prayer' ); ?></strong>
			</label>
			<label for="prayer_anonymous">
				<input type="checkbox" name="prayer_anonymous" value="1" />
				<span>Yes</span>
			</label>
		</p>

		<p>	
			<input type="submit" value="Send Prayer" />
			<input type="hidden" name="prayer-submission" value="1" />
		</p>

	</form>
	
<?php
	endif; ?>
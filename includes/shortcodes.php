<?php

// Add Shortcode
function prayers_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'count' => '10',
			'start_date' => 'last month',
			'end_date' => 'today',
		), $atts )
	);

	// WP_Query arguments
	$args = array (
		'post_type'              => array( 'prayer' ),
		'post_status'            => array( 'publish' ),
		'meta_query' => array(
			array(
				'key' => 'meta-prayer-anonymous',
				'value' => true,
				'compare' => 'NOT LIKE',
			),
		),
	);

	// The Query
	$query = new WP_Query( $args );

	// start a buffer to capture output
	ob_start();

	get_template_part('prayers');
	
	// The Loop
	if ( $query->have_posts() ) {
		echo '<ul>';
		while ( $query->have_posts() ) {
			$query->the_post();

			// Get custom metadata

			echo '<li>';
			echo '<h3 class="prayer-title">' . get_the_title() . '</h3>';
			echo '<div class="prayer-content">' . get_the_content() . '</div>';
			echo '</li>';
		}
		echo '</ul>';
	} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();

	// capture the output and return it to the hook
	$output = ob_get_contents(); // end output buffering
    ob_end_clean(); // grab the buffer contents and empty the buffer
    return $output;
}

add_shortcode( 'prayers', 'prayers_shortcode' );

function prayers_form( $atts ) {
	// Attributes
	extract( shortcode_atts(
		array(
			'anonymous' => true
		), $atts )
	);

	// start a buffer to capture output
	ob_start();

	if (count($_POST) > 0): ?>

	<p>Thanks for submitting your prayer request.</p>
	
	<?php else: ?>
	
	<style type="text/css">
		.prayer-form label.hide { display: none; }
	</style>
	
	<h3 id="prayer-form-title">Send a prayer</h3>
	
	<form method="post" class="prayer-form" action="">
		<?php wp_nonce_field( basename(__FILE__), 'prayer_nonce' ); ?>

		<p>
			<label for="prayer_title" class="hide"><?php echo __('Prayer Title', 'prayer') ?></label>
			<input type="text" name="prayer_title" placeholder="Prayer Title" />
		</p>

		<p>
			<label for="prayer_content" class="hide"><?php echo __('Prayer Request', 'prayer') ?></label>
			<textarea name="prayer_content" rows="4" placeholder="Please enter your request here..."></textarea>
		</p>

		<p>
			<label for="prayer_name" class="hide"><?php echo __('Your Name', 'prayer') ?></label>
			<input type="text" name="prayer_name" placeholder="Your Name"/>
		</p>

		<p>
			<label for="prayer_email" class="hide"><?php echo __('Your Email', 'prayer') ?></label>
			<input type="text" name="prayer_email" placeholder="Your Email" />
		</p>

		<?php

		$prayer_category = array( 'prayer_category' );
		$args = array(
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => false
		);
		$prayer_categories = get_terms($prayer_category, $args);
		?>

		<p>
			<label for="prayer_category">
				<strong><?php echo __('Categories'); ?></strong>
			</label><br />
			<?php foreach ($prayer_categories as $category): ?>
				<label for="<?php echo $category->slug; ?>">
					<input type="checkbox" name="prayer_category[]" value="<?php echo $category->slug; ?>" /> <?php echo $category->name ?> &nbsp;
				</label>
			<?php endforeach; ?>
		</p>

		<?php

		$prayer_location = array( 'prayer_location' );
		$args = array(
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => false
		);
		$prayer_locations = get_terms($prayer_location, $args);
		?>

		<p>
			<label for="prayer_location">
				<strong><?php echo __('Locations'); ?></strong>
			</label><br />
			<?php foreach ($prayer_locations as $location): ?>
				<label for="<?php echo $location->slug; ?>">
					<input type="checkbox" name="prayer_location[]" value="<?php echo $location->slug; ?>" /> <?php echo $location->name ?> &nbsp;
				</label>
			<?php endforeach; ?>
		</p>

		<p>
			<label>
				<strong><?php echo __('Would you like this prayer request to be anonymous?', 'prayer' ); ?></strong>
			</label>
			<br /><label for="prayer_anonymous">
				<input type="checkbox" name="prayer_anonymous" value="yes" />
				<span>Yes</span>
			</label>
		</p>

		<p>
			<input type="submit" value="Send Prayer" />
			<input type="hidden" name="prayer-submission" value="1" />
		</p>

	</form>
	
	<?php

	endif;
	
	// capture the output and return it to the hook
	$output = ob_get_contents(); // end output buffering
    ob_end_clean(); // grab the buffer contents and empty the buffer
    return $output;
}

add_shortcode( 'prayers_form', 'prayers_form' );
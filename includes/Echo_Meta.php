<?php
/**
 * Build Meta Boxes
 *
 * Build the metabox used for the Prayer edit page. This adds options for 
 * storing name, email, and location, as well as other metadata. This is also 
 * where the meta save process is found. It's straightforward other than a
 * call to process location data using the echo_save_meta_location plugin 
 * helper.
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

class Echo_Meta
{

	/**
	 * Class Construct
	 */
	public function __construct()
	{
		add_action( 'add_meta_boxes', array( $this, 'add_prayer_metaboxes' ) );
		add_action( 'save_post', array( $this, 'prayer_meta_save' ) );
	}

	/**
	 * Build Prayer Meta Box
	 * @since  0.9.0
	 */
	public function add_prayer_metaboxes() {
		add_meta_box(
			'prayer_answered', 
			__('Prayer Meta', 'prayer'), 
			array( $this, 'prayer_answered_cb' ), 
			'prayer', 
			'side', 
			'high');
	}

	/**
	 * HTML Output Callback
	 * @param  object Post object
	 * @return html
	 * @since 0.9.0
	 */
	public function prayer_answered_cb( $post ) {
	    // Noncename needed to verify where the data originated
		wp_nonce_field( basename(__FILE__), 'prayer_nonce' );
		$post_meta = get_post_meta( $post->ID );
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
			<ul class="echo-geocode">
				<li>Latitude: <?php echo $latitude; ?></li>
				<li>Longitude: <?php echo $longitude; ?></li>
				<li>Address: <?php echo $formatted; ?></li>
				<li>Country: <?php echo $long; ?> (<?php echo $short ?>)</li>
			</ul>
		</div>


		<?php
		endif;
	    
	}

	/**
	 * Save the meta information
	 * @param  integer Post ID
	 * @since  0.9.0
	 */
	public function prayer_meta_save( $post_id = 0 ) {
		if ( $post_id == 0 ) return;

		// Checks save status
	    $is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    $is_valid_nonce = ( isset( $_POST[ 'prayer_nonce' ] ) && wp_verify_nonce( $_POST[ 'prayer_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	 
	    // Exits script depending on save status
	    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
	        return;
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'meta-prayer-answered' ] ) ) {
	        update_post_meta( $post_id, 'meta-prayer-answered', sanitize_text_field( $_POST[ 'meta-prayer-answered' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'meta-prayer-anonymous' ] ) ) {
	        update_post_meta( $post_id, 'meta-prayer-anonymous', sanitize_text_field( $_POST[ 'meta-prayer-anonymous' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'meta-prayer-name' ] ) ) {
	    	update_post_meta( $post_id, 'meta-prayer-name', sanitize_text_field( $_POST[ 'meta-prayer-name' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'meta-prayer-email' ] ) ) {
	    	update_post_meta( $post_id, 'meta-prayer-email', sanitize_text_field( $_POST[ 'meta-prayer-email' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'meta-prayer-location' ] ) ) {
	    	update_post_meta( $post_id, 'meta-prayer-location', sanitize_text_field( $_POST[ 'meta-prayer-location' ] ) );

	    	// get geocoded data from location
	    	$location = Echo_Plugin_Helper::parse_location( sanitize_text_field( $_POST[ 'meta-prayer-location' ] ) );
	    	Echo_Plugin_Helper::save_location_meta( $post_id, $location );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if( isset( $_POST[ 'meta-prayer-count' ] ) ) {
	    	update_post_meta( $post_id, 'meta-prayer-count', sanitize_text_field( $_POST[ 'meta-prayer-count' ] ) );
	    }

	    // Checks for input and sanitizes/saves if needed
	    if ( isset( $POST[ 'meta-prayer-lang' ] ) ) {
	    	update_post_meta( $post_id, 'meta-prayer-lang', sanitize_text_field($_POST['meta-prayer-lang']) );
	    }

	}

}
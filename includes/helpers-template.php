<?php
/**
 * Template Helpers
 *
 * Provideds helpers to be used inside of template files for things like
 * buttons, lists, etc.
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-2.0+
 * @version   0.1.0
 */

/**
 * Terms List
 * @param  integer ID
 * @param  string Taxonomy Name
 * @return html Output for template
 * @since  0.1.0
 */
function echo_get_terms_list( $id = 0, $taxonomy = null ) {
	if ( is_null($taxonomy) ) { return 'Taxonomy not supplied'; }

	// get the categories for custom post type
	$categories = get_the_terms( $id, $taxonomy );
	// return a wrapped list
	if ( $categories && ! is_wp_error( $categories ) ) {
		// start the output
		$output = "";
		// create a categories array to store term names
		$categories_list = array();
		foreach ( $categories as $term ) {
			$categories_list[] = $term->name;
		} 
		// build the output for each category
		foreach ($categories_list as $category) {
			$output .= '<span class="echo echo-box category taxonomy-' . $taxonomy . '">';
			$output .= $category;
			$output .= '</span>';
		}
	}
	// return the html output to the template
	return $output;
}

/**
 * Build Prayer Button
 *
 * Gets the prayer count and builds an interactive button that allows users
 * to say they've prayed for the request on screen. Thier response is stored
 * in html5 localStorage to check against whether they've prayed for a
 * specific request before or not.
 * 
 * @param  integer ID
 * @return string html content
 * @since  0.1.0
 */
function echo_get_prayed_button( $id = 0 ) {
	if ( $id == 0 ) return;
	// get the current prayer count and set to 0 if it's empty
	$prayer_count = get_post_meta( $id, 'meta-prayer-count', 1);
	if ( empty($prayer_count) ) {
		$prayer_count = 0;
	}
	// build the prayer button
	?>
		<div class="echo-prayer-button" data-prayer-id="<?php the_ID(); ?>">
			<span class="echo-prayer-count prayer-<?php the_ID(); ?>"><?php echo $prayer_count; ?></span>
			<span class="echo-pray-button">
				<form class="echo-prayed" action="" method="post" data-prayer-id="<?php the_ID(); ?>">
					<?php wp_nonce_field( basename(__FILE__), 'prayer_nonce' ); ?>	
					<input type="hidden" name="prayer_id" value="<?php the_ID(); ?>" />
					<input type="submit" value="Pray" />
					<input type="hidden" name="prayer-click" value="1" />
				</form>
			</span>
		</div>

	<?php
}

/**
 * Get Prayer Location
 * @param  integer ID
 * @return html Location string
 * @since  0.1.0
 */
function echo_get_prayer_location( $id = 0 ) {
	if ( $id == 0) { return; }
	// get the prayer location
	$prayer_location = get_post_meta( $id, 'meta-prayer-location', 1);
	if ( empty($prayer_location) ) { return; }
	// build the html
	?><span class="echo-box"><?php echo $prayer_location; ?></span><?
}

/**
 * Get Name of Prayer Request Submitter
 * @param  integer ID
 * @return string Name of submitter
 * @since  0.1.0
 */
function echo_get_prayer_name( $id = 0 ) {
	if ( $id == 0) { return; }
	// get the submitter name
	$prayer_name = get_post_meta( $id, 'meta-prayer-name', 1);
	if ( empty($prayer_name) ) { return; }
	// build the html
	?><span class="echo-prayer-name"><?php echo $prayer_name; ?></span><?
}

/**
 * Get Prayer Count
 * @param  integer ID
 * @return string
 * @since  0.1.0
 */
function echo_get_prayer_count( $id = 0 ) {
	if ($id == 0) return 0;
	// get the prayer count and set to 0 if it doesn't exist
	$prayer_count = get_post_meta( $id, 'meta-prayer-count', 1);
	if ( empty($prayer_count) ) {
		$prayer_count = 0;
	}
	// set language specific output
	if ($prayer_count == 1) {
		$output = __("Prayed once", "echo");
	}
	else {
		$output = __("Prayed", "echo") . " " . $prayer_count . " " . __("times", "echo");		
	}
	// return the html
	return $output;
}

/**
 * Get Avatar
 * @param  integer ID
 * @param  integer Size of avatar
 * @return string Html string with avatar image
 * @since  0.1.0 
 */
function echo_get_avatar( $id = 0, $size = 26 ) {
	if ($id == 0) return;
	// get te email associated with the prayer posting and build avatar
	$email = get_post_meta( $id, 'meta-prayer-email', 1);
	// return the html
	return get_avatar( $email, $size );
}
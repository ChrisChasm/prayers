<?php
/**
 * Build Submenu Pages
 *
 * Builds submenu pages for things like settings, feed documentation, etc. 
 * These pages will be listed under the Prayers admin links section in the 
 * sidebar.
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

/**
 * Build Feeds Menu
 * @return hook
 * @since  0.9.0
 */
function prayer_feeds_menu() {
	add_submenu_page('edit.php?post_type=prayer', 'Feeds', 'Feeds', 'edit_posts', 'prayer_feeds', 'prayer_feeds_cb');
}

/**
 * Add Pending Menu
 *
 * Builds the pending menu along with a post pending count for display in the 
 * admin links section of the sidebar.
 * 
 * @return html
 * @since  0.9.0
 */
function prayer_pending_menu() {

	global $wpdb;
	$query = "SELECT COUNT(*) FROM wp_posts WHERE post_status = 'pending' AND post_type = 'prayer'";
	$post_count = $wpdb->get_var($query);

	if ($post_count != 0) {

		$post_count_string = ' <span class="echo-update-count">' . $post_count . '</span>';		
		add_submenu_page(
	        'edit.php?post_type=prayer',
	        '',
	        'Pending' . $post_count_string,
	        'edit_posts',
	        'edit.php?post_type=prayer&post_status=pending',
	        ''
	    );
	}
}

/**
 * Build the Feeds Page
 *
 * This is a callback for prayer_feeds_menu. It generates html to be
 * displayed on this submenu page.
 * 
 * @return html
 * @since  0.9.0
 */
function prayer_feeds_cb() {
	?>
   	<div class="wrap">
    	<h2>Prayer Feeds</h2>

    	<div id="col-container">

    		<div id="col-right">
    			<div class="col-wrap">

	    			<h3>RSS Feeds</h3>

	    			<table>
		    			<thead>
			    			<tr>
			    				<td><strong>Type</strong></td>
			    				<td><strong>Feed</strong></td>
			    			</tr>
		    			</thead>
		    			<tbody>
			    			<tr>
				    			<td>By Most Recent</td>
				    			<td><a target="_blank" href="<?php echo get_site_url(); ?>/prayers/feed"><?php echo get_site_url(); ?>/prayers/feed</a></td>
			    			</tr>
			    			<tr>
				    			<td>By Category</td>
				    			<td><a target="_blank" href="<?php echo get_site_url(); ?>/prayers/feed?prayer_category=north-america"><?php echo get_site_url(); ?>/prayers/feed?prayer_category=missions</a></td>
			    			</tr>
			    			<tr>
				    			<td>By Location</td>
				    			<td><a target="_blank" href="<?php echo get_site_url(); ?>/prayers/feed?prayer_location=north-america"><?php echo get_site_url(); ?>/prayers/feed?prayer_location=north-america</a></td>
			    			</tr>
			    			<tr>
				    			<td>By Tags</td>
				    			<td><a target="_blank" href="<?php echo get_site_url(); ?>/prayers/feed?prayer_tag=health,supplies"><?php echo get_site_url(); ?>/prayers/feed?prayer_tag=health,supplies</a></td>
			    			</tr>
		    			</tbody>
	    			</table>

	    			<h3>JSON Feeds</h3>

	    			<table>
	    				<thead>
		    				<tr>
		    					<td><strong>Type</strong></td>
		    					<td><strong>Feed</strong></td>
		    				</tr>
	    				</thead>
	    				<tbody>
			    			<tr>
						    	<td>By Most Recent </td><td><a target="_blank" href="<?php echo get_site_url(); ?>/wp-json/wp/v2/prayers"><?php echo get_site_url(); ?>/wp-json/wp/v2/prayers</a></td>
							</tr>
							<tr>
						    	<td>By Locations </td><td><a target="_blank" href="#"><?php echo get_site_url(); ?>/prayers/json?location=north_america</a></td>
							</tr>
							<tr>
						    	<td>By Categories </td><td><a target="_blank" href="#"><?php echo get_site_url(); ?>/prayers/json?category=missions</a></td>
							</tr>
							<tr>
						    	<td>By Tags </td><td><a target="_blank" href="#"><?php echo get_site_url(); ?>/prayers/json?tags=health,supplies</a></td>
						    </tr>
						</tbody>
			    	</table>

    			</div>
    		</div>

    		<div id="col-left">
	    		<div class="col-wrap">

	    			<p>Echo provides both RSS and JSON feeds for your prayer requests. This gives you the ability to allow subscribers to subsribe to RSS or integrate the prayers on your website into other third-party services.</p>

	    			<p>These feeds only display published prayers.</p>

	    		</div>
    		</div>

    	</div>

   	</div>
  	<?php
}

/**
 * Reorder Submenues
 *
 * Reorders submenus for the prayer admin links section.
 * 
 * @param  array Menu Order
 * @return array Menu Order
 * @since  0.9.0
 */
function echo_prayer_submenu_order( $menu_ord ) {
    global $submenu;

    // Enable the next line to see all menu orders
    // echo '<pre>'.print_r($submenu['edit.php?post_type=prayer'],true).'</pre>';

    $arr = array();
    $arr[] = $submenu['edit.php?post_type=prayer'][5]; // all prayers
    $arr[] = $submenu['edit.php?post_type=prayer'][17]; // pending
    $arr[] = $submenu['edit.php?post_type=prayer'][10]; // add new
    $arr[] = $submenu['edit.php?post_type=prayer'][15]; // categoris
    $arr[] = $submenu['edit.php?post_type=prayer'][16]; // tags
    $arr[] = $submenu['edit.php?post_type=prayer'][18]; // feeds
    $arr[] = $submenu['edit.php?post_type=prayer'][19]; // settings
    $submenu['edit.php?post_type=prayer'] = $arr;

    return $menu_ord;
}

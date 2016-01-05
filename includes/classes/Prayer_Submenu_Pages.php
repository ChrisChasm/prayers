<?php
/**
 * Build Submenu Pages
 *
 * Builds submenu pages for things like settings, feed documentation, etc. 
 * These pages will be listed under the Prayers admin links section in the 
 * sidebar.
 * 
 * @package   Prayer
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/prayer
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

class Prayer_Submenu_Pages 
{
    /**
     * PrayerSubmenuPages Class Construct
     */
    public function __construct() {
        add_action( 'admin_menu' , array( $this, 'prayer_feeds_page' ) );
        add_filter( 'custom_menu_order', array( $this, 'prayer_submenu_order' ) );
    }

    /**
     * Build Feeds Menu
     * @return hook
     * @since  0.9.0
     */
    public function prayer_feeds_page() {
        add_submenu_page(
            'edit.php?post_type=prayer', 
            'Feeds', 
            'Feeds', 
            'edit_posts', 
            'feeds',
            array( $this, 'prayer_feeds_page_cb' )
        );
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
    public function prayer_feeds_page_cb() {
        $templates = new Prayer_Template_Loader;
        // start a buffer to capture output
        $output = $templates->get_template_part( 'admin', 'feeds' );
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
    public function prayer_submenu_order( $menu_ord ) {
    
        // get pending review count
        global $wpdb;
        $query = "SELECT COUNT(*) FROM wp_posts WHERE post_status = 'pending' AND post_type = 'prayer'";
        $post_count = $wpdb->get_var($query);
        $post_count_string = ' <span class="prayer-update-count">' . $post_count . '</span>'; 

        global $submenu;

        // Enable the next line to see all menu orders
        // echo '<pre>'.print_r($submenu['edit.php?post_type=prayer'],true).'</pre>';

        $arr = array();
        $arr[] = $submenu['edit.php?post_type=prayer'][5]; // all prayers
        $arr[] = $submenu['edit.php?post_type=prayer'][10]; // add new
        $arr[] = $submenu['edit.php?post_type=prayer'][15]; // categoris
        $arr[] = $submenu['edit.php?post_type=prayer'][16]; // tags
        $arr[] = $submenu['edit.php?post_type=prayer'][17]; // feeds
        $arr[] = $submenu['edit.php?post_type=prayer'][18]; // feeds

        $all_prayers = $arr[0][0];
        $arr[0][0] = $all_prayers . $post_count_string;

        if ($post_count > 0 )
            $submenu['edit.php?post_type=prayer'] = $arr;

        return $menu_ord;
    }
}

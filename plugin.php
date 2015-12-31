<?php
/**
 * Plugin Name: Echo Prayer App
 * Plugin URI: http://github.com/kalebheitzman/echo
 * Description: Lets an organization share and update prayer requests via their website. This plugin also provides JSON feeds for other services to consume and requires the <a href="https://wordpress.org/plugins/rest-api/">WP REST API</a> be installed and activated first.
 * Version: 1.0
 * Author: Kaleb Heitzman
 * Author URI: http://github.com/kalebheitzman/echo
 *
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Define plugin directory constant
define( 'ECHO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Activate Plugin
 *
 * Requires WP REST API plugin for JSON feeds
 * Installs a user to associate front end prayer submissions to. If there is a
 * cleaner way than using wp_die to require dependencies for plugins then I'll
 * add it in.
 *
 * Future: find a better way to require dependencies other than wp_die.
 *
 * @since 0.9.0 
 */
function echo_plugin_activate(){

    // Require parent plugin
    if ( ! is_plugin_active( 'rest-api/plugin.php' ) and current_user_can( 'activate_plugins' ) ) {
        // Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires the <a href="https://wordpress.org/plugins/rest-api/">WP REST API (Version 2)</a> to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
    }
}
register_activation_hook( __FILE__, 'echo_plugin_activate' );

/**
 * Template Loader
 *
 * Allows template loading from plugin with echo_get_template_part(). This
 * will load templates from your themes/your_theme/templates directory first 
 * and then search for templates in plugins/echo/templates
 *
 * @since  0.9.0
 */
require ECHO_PLUGIN_DIR . 'includes/class-gamajo-template-loader.php';
require ECHO_PLUGIN_DIR . 'includes/class-echo-template-loader.php';

/**
 * Template Helpers
 *
 * Provideds helpers to be used inside of template files for things like
 * buttons, lists, etc.
 *
 * @since 0.9.0
 */
require ECHO_PLUGIN_DIR . 'includes/helpers-template.php';

/**
 * Plugin Helpers
 *
 * Plugin helpers that provide various helpers and functions that don't fit
 * anywhere else in the plugin. This is where repeatable function calls
 * (outside of shortcodes) will be stored.
 *
 * @since 0.9.0
 */
require ECHO_PLUGIN_DIR . 'includes/helpers-plugin.php';

/**
 * Front and Admin Styles
 *
 * Loads frontend and admin backend styles and scripts. These are vanilla css
 * and js files. In the future I may provide less/sass and coffeescript files
 * as well for advanced functionality. 
 *
 * @since 0.9.0
 */

// load frontend styles
require ECHO_PLUGIN_DIR . 'includes/scripts-frontend.php';
add_action( 'wp_enqueue_scripts', 'echo_register_styles' );

// load admin backend styles
require ECHO_PLUGIN_DIR . 'includes/scripts-admin.php';
add_action( 'admin_enqueue_scripts', 'echo_register_admin_styles' );

/**
 * Prayer Post Type
 *
 * This defines the Prayer custom post type. A majority of the prayer app data
 * will be stored under this custom post type. Taxonomy and heavy use of meta
 * are used as well to construct the different data functionalities that this
 * plugin provides.
 *
 * @since 0.9.0
 */
require ECHO_PLUGIN_DIR . 'includes/post_type_prayer.php';
add_action( 'init', 'prayer_post_type', 0 );

/**
 * Prayer Post Meta
 *
 * Meta is heavily used (instead of custom post fields) to save various data
 * that helps to define the context of the prayer request like subitter,
 * location, etc. You can find the Prayer Meta Box in the editing sidebar
 * area.
 *
 * @since 0.9.0
 */
require ECHO_PLUGIN_DIR . 'includes/post_type_meta.php';
add_action( 'add_meta_boxes', 'add_prayer_metaboxes', 0 );
add_action( 'save_post', 'prayer_meta_save' );

/**
 * Prayer Taxonomies
 *
 * Currently, a custom prayer category and tags taxonomy are associated with
 * the prayer post type to keep other taxonomies in your WP system clean. The
 * slugs used are prayer_category and prayer_tag. You can query off of these
 * slugs for any custom queries that you create. 
 *
 * @since 0.9.0
 */
require ECHO_PLUGIN_DIR . 'includes/taxonomy_prayer_category.php';
require ECHO_PLUGIN_DIR . 'includes/taxonomy_prayer_post_tag.php';
add_action( 'init', 'prayer_category_taxonomy', 1 );
add_action( 'init', 'prayer_post_tag_taxonomy', 2 );

/**
 * Prayer Post Type Menu
 *
 * Creates a prayer menu to be used in the main editing sidebar menu of your 
 * WP Install. Provides pages like settings, feeds, pending prayers, etc.
 *
 * Future ideas: MailChimp integration page
 *
 * @since  0.9.0
 */
require ECHO_PLUGIN_DIR . 'includes/post_type_menu.php';
add_action( 'admin_menu', 'prayer_pending_menu', 0 );
add_action( 'admin_menu' , 'prayer_feeds_menu', 0 );
add_filter( 'custom_menu_order', 'echo_prayer_submenu_order' );

/**
 * Echo Prayer Plugin Settings
 *
 * Creates a settings page for the plugin. Allows setting options like colors
 * enabling/disabling features, etc.
 *
 * @since  0.9.0 
 */
require ECHO_PLUGIN_DIR . 'includes/settings.php';
//add_action( 'admin_menu', 'echo_add_admin_menu' );
//add_action( 'admin_init', 'echo_settings_init' );

/**
 * Shortcodes
 *
 * Provides various prayer related shortcodes to use in the WYSIWYG editor
 * of wordpress. This includes shortcodes for prayer listings, a front-end
 * submission form, and prayer locations-based map.
 *
 * @since 0.9.0
 */
require ECHO_PLUGIN_DIR . 'includes/shortcodes.php';
add_shortcode( 'echo_prayers', 'echo_prayers_shortcode' );
add_shortcode( 'echo_prayers_form', 'echo_prayers_form_shortcode' );
add_shortcode( 'echo_prayers_map', 'echo_prayers_map_shortcode' );

/**
 * Admin Prayer Listing Page Columns
 *
 * Manipulates the prayer listing edit page to add columns to the listing
 * table with relevant data to the request like location, whether the prayer
 * has been answered, etc.
 *
 * @since 0.9.0
 */
require ECHO_PLUGIN_DIR . 'includes/post_type_columns.php';
add_filter( 'manage_prayer_posts_columns', 'echo_prayers_columns_head' );
add_action( 'manage_prayer_posts_custom_column', 'echo_prayers_columns', 10, 2 );

/**
 * Data Saving
 *
 * Echo lets anonymous users submit prayers from the front end. These
 * submissions are saved to the Prayer custom post type and marked as pending
 * review. They are also associated with an Echo user/author to help sort out
 * frontend submissions from submissions your authorized wordpress users can
 * make on the backend. Currently this includes a function to process frontend
 * form submissions and saving metadata on the backend.
 *
 * @since 0.9.0
 */
require ECHO_PLUGIN_DIR . 'includes/form-processing.php';
add_action( 'init', 'echo_prayer_form_submission' );
add_action( 'init', 'echo_prayed_click_submit');

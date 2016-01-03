<?php
/**
 * Plugin Name: Echo Prayers
 * Plugin URI: http://github.com/kalebheitzman/echo
 * Description: Lets an organization share and update prayer requests via their website. This plugin also provides JSON feeds for other services to consume and requires the <a href="https://wordpress.org/plugins/rest-api/">WP REST API</a> be installed and activated first.
 * Version: 0.9.0
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
 * Autoloader
 *
 * Autmagically loads classes from the echo/includes. Instantiates them in the
 * plugin file using the i.e. $echo_prayers = new EchoPrayers; format.
 */
spl_autoload_register(function ( $class ) {
	if ( is_readable( ECHO_PLUGIN_DIR . "includes/{$class}.php" ) )
		require ECHO_PLUGIN_DIR . "includes/{$class}.php";		
});
require 'vendor/autoload.php';

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
$echo_post_type_prayer = new Echo_Post_Type_Prayer;

/**
 * Install and Uninstall hooks
 *
 * Creates settings, echo user, as well as cleans up the database on an 
 * uninstall.
 *
 * @since 0.9.0
 */
if ( is_admin() )
	$echo_setup = new Echo_Plugin_Setup;

/**
 * Template Loader
 *
 * Allows template loading from plugin with echo_get_template_part(). This
 * will load templates from your themes/your_theme/templates directory first 
 * and then search for templates in plugins/echo/templates
 *
 * @since  0.9.0
 */
$echo_templates = new Echo_Template_Loader;

/**
 * Notifications
 *
 * Instantiate a notifications class to notifiy users about various prayer
 * actions. This includes things like incoming prayer requests, prayers being
 * answered, etc.
 *
 * @since 0.9.0
 */
if ( is_admin() )
	$echoNotifications = new Echo_Notifications;

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
$echo_frontend_scripts = new Echo_Frontend_Scripts;

// load admin backend styles
if ( is_admin() )
	$echo_admin_scripts = new Echo_Admin_Scripts;

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
$echo_meta = new Echo_Meta;

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
$echo_taxonomy_category = new Echo_Taxonomy_Category;
$echo_taxonomy_tags = new Echo_Taxonomy_Tags;

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
if ( is_admin() )
    $echo_submenu_pages = new Echo_Submenu_Pages;

/**
 * Virtual Pages
 *
 * Creates virtual pages like form confirmation that Echo can manage from 
 * settings without having to create and link pages from within WP.
 *
 * @since  0.9.0
 */
$echo_virtual_pages = new Echo_Virtual_Pages;

/**
 * Echo Prayer Plugin Settings
 *
 * Creates a settings page for the plugin. Allows setting options like colors
 * enabling/disabling features, etc.
 *
 * @since  0.9.0 
 */
if ( is_admin() )
	$echo_settings = new Echo_Settings;

/**
 * Shortcodes
 *
 * Provides various prayer related shortcodes to use in the WYSIWYG editor
 * of wordpress. This includes shortcodes for prayer listings, a front-end
 * submission form, and prayer locations-based map.
 *
 * @since 0.9.0
 */
$echo_shortcodes = new Echo_Shortcodes;

/**
 * Admin Prayer Listing Page Columns
 *
 * Manipulates the prayer listing edit page to add columns to the listing
 * table with relevant data to the request like location, whether the prayer
 * has been answered, etc.
 *
 * @since 0.9.0
 */
if ( is_admin() )
	$echo_admin_columns = new Echo_Admin_Columns;

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
$echo_form_processing = new Echo_Form_Processing;

/**
 * Echo Prayer JSON API
 *
 * Outputs JSON responses from /prayers/api.
 *
 * @since  0.9.0
 */
$echo_api = new Echo_API;


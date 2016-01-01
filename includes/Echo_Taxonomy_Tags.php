<?php
/**
 * Prayer Tags
 *
 * Generated with generatewp.com
 * 
 * @package   Echo
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/echo
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */

class Echo_Taxonomy_Tags
{
	/**
	 * Class Construct
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'prayer_post_tag_taxonomy' ), 2 );
	}

	/**
	 * Registers Prayer Tags
	 * @return hook
	 * @since  0.9.0 
	 */
	function prayer_post_tag_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Tags', 'Taxonomy General Name', 'prayer' ),
			'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'prayer' ),
			'menu_name'                  => __( 'Tags', 'prayer' ),
			'all_items'                  => __( 'All Tags', 'prayer' ),
			'parent_item'                => __( 'Parent Tag', 'prayer' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'prayer' ),
			'new_item_name'              => __( 'New Tag Name', 'prayer' ),
			'add_new_item'               => __( 'Add New Tag', 'prayer' ),
			'edit_item'                  => __( 'Edit Tag', 'prayer' ),
			'update_item'                => __( 'Update Tag', 'prayer' ),
			'separate_items_with_commas' => __( 'Separate tags with commas', 'prayer' ),
			'search_items'               => __( 'Search tags', 'prayer' ),
			'add_or_remove_items'        => __( 'Add or remove tags', 'prayer' ),
			'choose_from_most_used'      => __( 'Choose from the most used tags', 'prayer' ),
			'not_found'                  => __( 'Not Found', 'prayer' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => false,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => true,
			//'update_count_callback'      => 'prayer_post_tag_cb',	
		);
		register_taxonomy( 'prayer_tag', array( 'prayer' ), $args );

	}
}
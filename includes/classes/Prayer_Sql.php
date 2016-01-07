<?php
/**
 * Prayer Sql
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
class Prayer_Sql
{
	public static function get_all_emails()
	{
		global $wpdb;

		// build the sql statement
		$query = "	SELECT 		wp_posts.ID, 
								email.meta_value 	AS email,
								name.meta_value 	AS name
					FROM 		wp_posts
					
					LEFT JOIN 	wp_postmeta 		AS email
					ON 			wp_posts.ID = email.post_id
					AND 		email.meta_key = 'prayer-email'

					LEFT JOIN 	wp_postmeta 		AS name
					ON 			wp_posts.ID = name.post_id
					AND 		name.meta_key = 'prayer-name'

					WHERE 		wp_posts.post_status = 'publish'
					AND 		wp_posts.post_type = 'prayer'
				";

		// get the results
		$results = $wpdb->get_results( $query ); 
		
		return $results;
	}
	
}
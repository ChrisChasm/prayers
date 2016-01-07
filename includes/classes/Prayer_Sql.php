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
	/**
	 * Get a listing of all prayer emails and names
	 * @return object WPDB results
	 */
	public static function get_all_emails()
	{
		global $wpdb;

		// build the query
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
		// filter the results
		$results_filtered = self::cleanup_by_email( $results );
		return $results_filtered;

	}

	public static function get_newly_prayed()
	{	
		global $wpdb;
		
		// build the query
		$query = "	SELECT 		wp_posts.ID, 
								email.meta_value 	AS email
					FROM 		wp_posts
					
					LEFT JOIN 	wp_postmeta 		AS email
					ON 			wp_posts.ID = email.post_id
					AND 		email.meta_key = 'prayer-email'

					LEFT JOIN 	wp_postmeta 		AS prayed
					ON 			wp_posts.ID = prayed.post_id
					AND 		prayed.meta_key = 'prayer-prayed'

					LEFT JOIN 	wp_postmeta 		AS sent
					ON 			wp_posts.ID = sent.post_id
					AND 		sent.meta_key = 'prayer-email-sent'

					WHERE 		wp_posts.post_status = 'publish'
					AND 		wp_posts.post_type = 'prayer'
					AND 		prayed.meta_value = '1'
					AND 		sent.meta_value = '0'
				";

		// get the results
		$results = $wpdb->get_results( $query );
		// filter the results
		$results_filtered = self::cleanup_by_email( $results );
		return $results_filtered;
	}

	/**
	 * Cleanup by ematil
	 * @param  Object $results WPDB Results
	 * @return Object          WPDB Results
	 */
	private static function cleanup_by_email( $results )
	{
		$indexed = array();
		foreach ( $results as $key => $object )
		{
			$indexed[$object->email] = $object;
		}

		$results_filtered = array();
		foreach ( $indexed as $key => $object2 )
		{
			$results_filtered[] = $object2;
		}
		return $results_filtered;
	}


}
<h1>MailChimp</h1>
<?php
	// show flash messages
	Prayer_Template_Helper::flash_message();

	// get mailchimp
	$mc = new Prayer_Mailchimp;

	if ( ! isset( $mc->mc_api->apikey ) ): 
	// display a message telling the user to update thier key
		?>
		<p>Please enter a MailChimp API Key on the <a href="<?php echo get_site_url() ?>/wp-admin/edit.php?post_type=prayer&amp;page=settings">Prayer Settings page.</a></p>
	<?php else: 
	// display the mailchimp integration page
	?>

		<p>Your API Key: <code><?php echo $mc->mc_api->apikey; ?></code></p>

		<h2>Select List</h2>

		<?php 
			// lists
			$lists = $mc->mc_api->lists->getList();
		?>
		<form method="post" action="">
		
			<p>Sync a <a href="http://mailchimp.com" target="_blank">MailChimp</a> list and pre-defined segments from people who have
submitted prayer requests on your website.</p>
		
			<select name="prayer_mailchimp_list">
				<option value="">Select a list</option>
				<?php foreach($lists['data'] as $list): ?>
					<option value="<?php echo $list['id'] ?>|<?php echo $list['name'] ?>" <?php if( $list['id'] == $mc->current_list ) { echo 'selected'; } ?>><?php echo $list['name'] ?></option>
				<?php endforeach; ?>
			</select>

			<?php wp_nonce_field( basename(__FILE__), 'mailchimp_nonce' ); ?>
			<input type="hidden" name="mailchimp-submission" value="1" />
			<input type="submit" value="Submit" class="prayer-button" />
		</form>

		<?php if ( ! empty( $mc->current_list ) ): ?>

			<h2>Actions</h2>

			<ul>
				<li>
					<form action="" method="post">
						<?php wp_nonce_field( basename(__FILE__), 'mailchimp_nonce' ); ?>
						<input type="hidden" name="mailchimp-sync-list" value="1" />
						<input type="submit" value="Sync List" class="prayer-button sync" />
						<span>All <?php echo get_option( 'prayer_mailchimp_list_name' ) ?> Emails</span>
					</form>
				</li>
				<li>
					<form action="" method="post">
						<?php wp_nonce_field( basename(__FILE__), 'mailchimp_nonce' ); ?>
						<input type="hidden" name="mailchimp-sync-segment" value="1" />
						<input type="submit" value="Sync Segment" class="prayer-button sync" />
						<select name="segment">
							<option>Choose a segment to sync</option>
							<?php $prayer_segments = $mc->mc_segments; 
								foreach( $prayer_segments as $key => $segment): ?>
								<option value="<?php echo $key ?>"><?php echo $segment ?></option>
							<?php endforeach; ?>
						</select>					
					</form>
				</li>
				<li>
					<form action="" method="post">
						<?php wp_nonce_field( basename(__FILE__), 'mailchimp_nonce' ); ?>
						<input type="hidden" name="mailchimp-sync-groups" value="1" />
						<input type="submit" value="Sync Groups" class="prayer-button sync" />
						<?php
							$prayer_category = array( 'prayer_category' );
							$args = array(
								'orderby' => 'name',
								'order' => 'ASC',
								'hide_empty' => false 
							);
							$prayer_categories = get_terms($prayer_category, $args);
							foreach( $prayer_categories as $term )
							{
								$prayer_cat_list[] = $term->name;
							}
							$prayer_cat_list = implode(", ", $prayer_cat_list);
						?>
						<span><?php echo $prayer_cat_list ?>, Answered Prayers</span>					
					</form>
				</li>
			</ul>
		<?php endif; ?>

	<?php endif; ?>
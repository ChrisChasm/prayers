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
				<option>Select a list</option>
				<?php foreach($lists['data'] as $list): ?>
					<?php var_dump($mc->current_list); ?>
					<option value="<?php echo $list['id'] ?>" <?php if( $list['id'] == $mc->current_list ) { echo 'selected'; } ?>><?php echo $list['name'] ?></option>
				<?php endforeach; ?>
			</select>

			<?php wp_nonce_field( basename(__FILE__), 'mailchimp_nonce' ); ?>
			<input type="hidden" name="mailchimp-submission" value="1" />
			<input type="submit" value="Submit" />

		</form>

		<h2>Actions</h2>

		<ul>
			<li>
				<form action="" method="post">
					<?php wp_nonce_field( basename(__FILE__), 'mailchimp_nonce' ); ?>
					<input type="hidden" name="mailchimp-sync-all" value="1" />
					<input type="submit" value="Sync All" />
					<span>Sync List and all segments</span>
				</form>
			</li>
			<li>
				<form action="" method="post">
					<?php wp_nonce_field( basename(__FILE__), 'mailchimp_nonce' ); ?>
					<input type="hidden" name="mailchimp-sync-list" value="1" />
					<input type="submit" value="Sync List" />
					<span>All emails</span>
				</form>
			</li>
			<li>
				<form action="" method="post">
					<?php wp_nonce_field( basename(__FILE__), 'mailchimp_nonce' ); ?>
					<input type="hidden" name="mailchimp-sync-segment" value="1" />
					<input type="hidden" name="segment" value="unanswered-requests" />
					<input type="submit" value="Sync Segment" />
					<span>Unaswered requests</span>
				</form>
			<li>
				<form action="" method="post">
					<?php wp_nonce_field( basename(__FILE__), 'mailchimp_nonce' ); ?>
					<input type="hidden" name="mailchimp-sync-segment" value="1" />
					<input type="hidden" name="segment" value="new-prayed-requests" />
					<input type="submit" value="Sync Segment" />
					<span>New Prayed-for requests</span>
				</form>
			</li>
		</ul>

	<?php endif; ?>
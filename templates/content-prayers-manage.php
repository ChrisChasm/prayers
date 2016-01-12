<?php
	// prayer navigation
	Prayer_Template_Helper::get_navigation();

	// show flash messages
	Prayer_Template_Helper::flash_message();

	// The Query
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) : ?>

	<ul id="prayers" class="prayer prayer-listing prayer-js">
	
		<?php while ( $query->have_posts() ):
			$query->the_post(); 

			$id = get_the_ID();

			?>
	
			<li>
				<h3 class="prayer-title">
					<a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
				</h3>

				<div class="prayer prayer-meta">
					<ul>
						<li><?php echo Prayer_Template_Helper::get_prayed_button( $id ); ?></li>
						<?php if ( ! empty( Prayer_Template_Helper::get_prayer_location($id) ) ): ?>
							<li><?php echo Prayer_Template_Helper::get_prayer_location($id); ?></li>
						<?php endif; ?>
						<li class="prayer-taxonomy"><?php echo Prayer_Template_Helper::get_terms_list($id, 'prayer_category'); ?></li>
						<li class="prayer-taxonomy"><?php echo Prayer_Template_Helper::get_terms_list($id, 'prayer_location'); ?></li>
						<?php if ( Prayer_Template_Helper::get_prayer_answered($id) ): ?>
							<li class="prayer prayer-answered"><span class="prayer prayer-answered prayer-box">Answered</span></li>
						<?php endif; ?>
					</ul>
				</div>

				<div class="prayer-content">
					<?php the_content() ?>
				</div>
				
				<?php if ( ! Prayer_Template_Helper::get_prayer_answered($id) ): ?>
					<div class="prayer-response">
						<p><a href="#" data-id="response-<?php the_ID() ?>" class="prayer-response">Has this prayer been answered?</a></p>
						<form action="" method="post" data-id="response-<?php the_ID() ?>" class="prayer-response">
							<?php wp_nonce_field( basename(__FILE__), 'prayer_nonce' ); ?>
							<input type="hidden" name="prayer-id" value="<?php the_ID() ?>" />
							<input type="hidden" name="prayer-answered" value="1" />

							<p>
								<label for="prayer-response" class="hide">How has this prayer been answered?</label>
								<textarea name="prayer-response" placeholder="How has this prayer been answered?"></textarea>
							</p>

							<p>
								<input type="submit" value="Submit" />
							</p>
						</form>
					</div>
				<?php endif; ?>
				<?php if ( Prayer_Template_Helper::get_prayer_answered($id) ): ?>
					<div class="prayer-answered">
						<?php echo get_post_meta( $id, 'prayer-response', 1); ?>
					</div>
				<?php endif; ?>

			</li>
	
		<?php endwhile; ?>
		
		<div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
		<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>

	</ul>

	<?php else: ?>

		<p>Sorry, you haven't submitted any prayers yet.</p>

	<?php endif;

	/* Restore original Post Data */
	// wp_reset_postdata(); ?>
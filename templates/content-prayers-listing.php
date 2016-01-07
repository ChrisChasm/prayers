<?php

	// The Query
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) : ?>

	<ul id="prayers" class="prayer prayer-listing">
	
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

						<li class="prayer-avatar-small"><?php echo Prayer_Template_Helper::get_avatar( $id, 27 ); ?></li>
						<li><?php echo Prayer_Template_Helper::get_prayed_button( $id ); ?></li>
						<?php if ( $prayer_answered ): ?>
							<li class="prayer prayer-answered"><span class="prayer prayer-answered">Answered</span></li>
						<?php endif; ?>
						<?php if ( ! empty( Prayer_Template_Helper::get_prayer_location($id) ) ): ?>
							<li><?php echo Prayer_Template_Helper::get_prayer_location($id); ?></li>
						<?php endif; ?>
						<li class="prayer-taxonomy"><?php echo Prayer_Template_Helper::get_terms_list($id, 'prayer_category'); ?></li>
						<li class="prayer-taxonomy"><?php echo Prayer_Template_Helper::get_terms_list($id, 'prayer_location'); ?></li>

					</ul>
				</div>

				<div class="prayer-content">
					<span class="prayer prayer-name"><?php echo Prayer_Template_Helper::get_prayer_name($id); ?></span>
					<?php the_content() ?>
				</div>
				
			</li>
	
		<?php endwhile; ?>
		
		<div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
		<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>

	</ul>

	<?php else: ?>

		<h3>Sorry. No prayers have been sent yet.</h3>

	<?php endif;

	/* Restore original Post Data */
	// wp_reset_postdata(); ?>
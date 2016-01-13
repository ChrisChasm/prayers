<?php
// prayer navigation
Prayer_Template_Helper::get_navigation();

// show flash messages
Prayer_Template_Helper::flash_message();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args['paged'] = $paged;

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
					<span class="prayer prayer-name"><?php echo Prayer_Template_Helper::get_prayer_name($id); ?></span>
					<?php the_content() ?>
				</div>

				<?php if ( Prayer_Template_Helper::get_prayer_answered($id) ): ?>
					<div class="prayer-answered">
						<?php echo get_post_meta( $id, 'prayer-response', 1); ?>
					</div>
				<?php endif; ?>
				
			</li>
	
		<?php endwhile; ?>
		
	</ul>

	<?php 

		Prayer_Template_Helper::pagination( $query->max_num_pages ); 
		/* Restore original Post Data */
		wp_reset_query(); 

	else: ?>

	s<h3>Sorry. No prayers have been submitted yet.</h3>

	<?php endif; 

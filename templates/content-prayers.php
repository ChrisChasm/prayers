<?php

	// WP_Query arguments
	$args = array (
		'post_type'              => array( 'prayer' ),
		'post_status'            => array( 'publish' ),
		'meta_query' => array(
			array(
				'key' => 'meta-prayer-anonymous', // filters out anonymous prayers
				'value' => 0,
				'compare' => 'LIKE',
			),
		),
	);

	// The Query
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) : ?>

	<ul id="echo-prayers" class="echo prayer-listing">
	
		<?php while ( $query->have_posts() ):
			$query->the_post(); 

			$id = get_the_ID();

			?>
	
			<li>
				<h3 class="prayer-title"><?php the_title() ?></h3>

				<div class="echo prayer-meta">
					<ul>

						<li><?php echo get_echo_prayed_button() ?></li>
						<?php if ( $prayer_answered ): ?>
							<li class="echo prayer-answered"><span class="echo prayer-answered">Answered</span></li>
						<?php endif; ?>
						<?php if ( ! empty( get_echo_prayer_location($id) ) ): ?>
							<li><?php echo get_echo_prayer_location($id); ?></li>
						<?php endif; ?>
						<li><?php echo get_echo_terms_list($id, 'prayer_category'); ?></li>
						<li><?php echo get_echo_terms_list($id, 'prayer_location'); ?></li>

					</ul>
				</div>

				<div class="prayer-content">
					<span class="echo prayer-name"><?php echo get_echo_prayer_name($id); ?></span>
					<?php the_content() ?>
				</div>
				
			</li>
	
		<?php endwhile; ?>
	
	</ul>

	<?php else: ?>

		<h3>Sorry. No prayers have been sent yet.</h3>

	<?php endif;

	/* Restore original Post Data */
	wp_reset_postdata(); ?>
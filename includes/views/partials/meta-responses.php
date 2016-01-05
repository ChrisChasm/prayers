<div id="prayer-responses" class="inside hidden">

	<?php $response = get_post_meta( get_the_ID(), 'prayer-response', true ); ?>
	<textarea name="prayer-response" placeholder="How was this prayer answered?"><?php
		echo $response;
	?></textarea>

</div>
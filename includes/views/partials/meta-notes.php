<div class="inside">
    <div id="prayer-notes">
    	<?php $notes = get_post_meta( get_the_ID(), 'prayer-notes', true ); ?>
    	<?php if ( is_array($notes) ) {
    		foreach ( $notes as $key => $note ) { ?>
            	<textarea name="prayer-notes[<?php echo $key; ?>]"><?php echo $note; ?></textarea>
        <?php }
        } ?>
    </div><!--/prayer-notes-->
    <p><input type="submit" id="prayer-add-note" value="Add Note" /></p>
</div>
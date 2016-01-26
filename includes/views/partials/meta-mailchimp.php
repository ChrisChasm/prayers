<div class="inside hidden">

  <div class="column">

    <?php // ready for sync
    $prayer_ready_for_sync = $post_meta['prayer-email-ready-for-sync'][0];
    if ( $prayer_ready_for_sync == "1" ) {
      $ready_for_sync_checked = 'checked="checked"';
    }
    ?>
    <p>
      <label><input type="checkbox" name="prayer-email-ready-for-sync" value="1" <?php echo $ready_for_sync_checked ?>><?php echo __( 'Ready for sync?', 'prayer' ) ?></input>
    </p>

    <?php // email synced
    $prayer_email_synced = $post_meta['prayer-email-synced'][0];
    if ( $prayer_email_synced == "1" ) {
      $email_synced_checked = 'checked="checked"';
    }
    ?>
    <p>
      <label><input type="checkbox" disabled name="prayer-email-synced" value="1" <?php echo $email_synced_checked ?>><?php echo __( 'Email synced?', 'prayer' ) ?></input>
    </p>

  </div>

  <div class="column">

  </div>

  <div class="column">

  </div>

</div>

<?php
/**
 * Activate Plugin
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

class Prayer_Plugin_Setup
{

    protected $plugin_path;

    public function __construct() {
        $path = realpath( plugin_dir_path(__FILE__) . "../../plugin.php" );
        $this->plugin_path = $path;

        register_activation_hook( $this->plugin_path, array( 'Prayer_Plugin_Setup', 'plugin_activate' ) );
        register_deactivation_hook( $this->plugin_path, array( 'Prayer_Plugin_Setup', 'plugin_deactivate' ) );
        register_uninstall_hook( $this->plugin_path, array( 'Prayer_Plugin_Setup', 'plugin_uninstall' ) );
    }
   
    /**
     * Activate Hook
     *
     * @since 0.9.0 
     */
    public function plugin_activate(){

        // Require parent plugin
        if ( ! is_plugin_active( 'rest-api/plugin.php' ) and current_user_can( 'activate_plugins' ) ) {
            // Stop activation redirect and show error
            wp_die('Sorry, but this plugin requires the <a href="https://wordpress.org/plugins/rest-api/">WP REST API (Version 2)</a> to be installed and active. <br><a href="' . admin_url( 'plugins.php' ) . '">&laquo; Return to Plugins</a>');
        }

        // install default options
        if ( ! get_option('prayer_settings_options') ) {
            $options = array(
                'notification_user' => 1,
                'prayer_form_response' => __( 'We have received your prayer request.', 'prayer' ),
                'button_primary_color' => '#2582EA',
                'button_secondary_color' => '#45D680',
                'button_text_color' => '#ffffff',
                'taxonomy_background_color' => '#efefef',
                'taxonomy_text_color' => '#333333',
                'categories_enabled' => "1",
                'tags_enabled' => "1",
            );
            add_option( 'prayer_settings_options', $options );
        }


        // create the default prayer user and set permissions to contributer.
        $username = 'prayer';
        if( null == username_exists( $username ) ) {

            $password = wp_generate_password( 12, true );
            $user_id = wp_create_user( $username, $password );
            
            $userdata = array(
                    'ID' => $user_id,
                    'nickname' => 'Prayer',
                    'display_name' => 'Prayer',
                    'first_name' => 'Prayer',
                    'description' => 'User for Prayer Plugin submission.',
                    'role' => 'contributer'
                );
            wp_update_user( $userdata );

        }

        // create tables to store mailchimp integration info
        global $wpdb;
        $table_name = $wpdb->prefix . "prayers_mailchimp";
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(11) NOT NULL AUTO_INCREMENT,
            post_id mediumint(11) NOT NULL,
            prayed_for smallint(1),
            email_sent smallint(1),
            PRIMARY KEY id (id),
            UNIQUE KEY post_id (post_id)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $db = dbDelta( $sql );

    }

    /**
     * Deactivate Hook
     *
     * @since 0.9.0 
     */
    public function plugin_deactivate() {

    }

    /**
     * Uninstall Hook
     *
     * @since 0.9.0
     */
    public function plugin_uninstall() {

        // delete all prayer requests
        $prayers = get_posts( array(
                'post_type' => 'prayer',
            )
        );
        foreach ( $prayers as $prayer )
        {
            wp_delete_post( $prayer->ID, true );
        }

        // delete prayer settings
        delete_option( 'prayer_settings_options' );

        // delete the prayer user
        $user = get_user_by( 'login', 'prayer' );
        wp_delete_user( $user->id );

    }

}
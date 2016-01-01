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

class Echo_Plugin_Setup
{

    protected $plugin_path;

    public function __construct() {
        $this->plugin_path = realpath( plugin_dir_path(__FILE__) . "../plugin.php" );

        register_activation_hook( $this->plugin_path, array( 'EchoPluginSetup', 'plugin_activate' ) );
        register_deactivation_hook( $this->plugin_path, array( 'EchoPluginSetup', 'plugin_deactivate' ) );
        register_uninstall_hook( $this->plugin_path, array( 'EchoPluginSetup', 'plugin_uninstall' ) );
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
        if ( ! get_option( 'echo_settings_options' ) ) {
            $op = array(
                'primary_color' => '#2582EA',
                'secondary_color' => '#45D680',
                'categories_enabled' => '1',
                'tags_enabled' => '1',
                'prayer_form_response' => __('Thanks for submitting your prayer request.', 'echo'),
            );
            add_option( 'echo_settings_options', $op );
        }


        // create the default echo user and set permissions to contributer.
        $username = 'echo';
        if( null == username_exists( $username ) ) {

            $password = wp_generate_password( 12, true );
            $user_id = wp_create_user( $username, $password );
            
            $userdata = array(
                    'ID' => $user_id,
                    'nickname' => 'Echo',
                    'display_name' => 'Echo',
                    'first_name' => 'Echo',
                    'description' => 'User for Echo Prayer Plugin submission.',
                    'role' => 'contributer'
                );
            wp_update_user( $userdata );

        }

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

        delete_option( 'echo_settings_options' );

        $user = get_user_by( 'login', 'echo' );
        wp_delete_user( $user->id );

    }

}
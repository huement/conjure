<?php

/**
 * Fired during plugin activation
 *
 * @link       https://myriadmobile.com
 * @since      1.0.0
 *
 * @package    Dokan_Upshot
 * @subpackage Dokan_Upshot/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Dokan_Upshot
 * @subpackage Dokan_Upshot/includes
 * @author     Derek <dscott@myriadmobile.com>
 */
class DU_ON {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        self::dokan_dss_activate_log( 'Dokan Upshot Activating');

        self::dokan_sub_summary_create_db();

        self::dokan_upshot_create_db();

        do_action('upshot_automatic');

        set_transient( 'dokan-upshot', 1 );

        if ( false == wp_next_scheduled( 'upshot_automatic' ) ) {
            wp_schedule_event( time(), 'hourly', 'upshot_automatic' );
        }

        if ( ! get_page_by_title( __( 'Dokan Upshot', 'dokan' ) ) ) {

            $page_id = wp_insert_post( array(
                'post_title'   => wp_strip_all_tags( __( 'Dokan Upshot', 'dokan' ) ),
                'post_content' => '[dv_page]',
                'post_status'  => 'publish',
                'post_type'    => 'page'
            ) );

            self::dokan_dss_activate_log( 'Dokan Upshot Post Inserted');
        }

        self::dokan_dss_activate_log( '-------- Upshot Activated -------- ');
	}

    /**
     * @param $msg
     * @param bool $admin
     */
    public static function dokan_dss_activate_log($msg, $admin=false)
    {
        $dirLog = plugin_dir_path( dirname(__FILE__));
        $message = sprintf("[%s] %s\n", date('d.m.Y h:i:s'), $msg);
        error_log($message, 3, $dirLog . 'dv.log');

        if($admin!==false) {
            $class = 'notice notice-error';
            $message = __( $msg, 'dokan' );
            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
        }
    }

    /**
     *  @brief Creates the Subscriber Summary Table
     */
    public static function dokan_sub_summary_create_db() {

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'dokan_sub_summary';

        if($wpdb->get_var( "show tables like '$table_name'" ) != $table_name)
        {
            $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            subscriber smallint(5) NOT NULL,
            lastupdate datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            $msg = "Created ".$table_name." table";
            self::dokan_dss_activate_log($msg);
        } else {
            $msg = "Table ".$table_name." was already created";
            self::dokan_dss_activate_log($msg);
        }

        return true;
    }

    public static function dokan_upshot_create_db() {

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'dokan_upshot';

        if($wpdb->get_var( "show tables like '$table_name'" ) != $table_name)
        {
            $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            subject text DEFAULT NULL,
            body text DEFAULT NULL,
            days smallint(5) DEFAULT NULL,
            template mediumtext DEFAULT NULL,
            variables mediumtext DEFAULT NULL,
            lastupdate datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            UNIQUE KEY id (id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            $msg = "Created ".$table_name." table";
            self::dokan_dss_activate_log($msg);
        } else {
            $msg = "Table ".$table_name." was already created";
            self::dokan_dss_activate_log($msg);
        }

        return true;
    }

}

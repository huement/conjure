<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://myriadmobile.com
 * @since      1.0.0
 *
 * @package    Dokan_Summary
 * @subpackage Dokan_Summary/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Dokan_Summary
 * @subpackage Dokan_Summary/includes
 * @author     Derek <dscott@myriadmobile.com>
 */
class DU_OFF {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        wp_clear_scheduled_hook( 'upshot_automatic' );
        self::dokan_dss_deactivate_log("Dokan UpShot Deactivated.");
	}

    public static function dokan_dss_deactivate_log($msg,$admin=false)
    {
        $dirLog = plugin_dir_path(dirname(__FILE__));
        $message = sprintf("[%s] %s\n", date('d.m.Y h:i:s'), $msg);
        error_log($message, 3, $dirLog . '/dv.log');

        if($admin!==false) {
            $class = 'notice notice-error';
            $message = __( $msg, 'dokan' );
            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
        }
    }
}

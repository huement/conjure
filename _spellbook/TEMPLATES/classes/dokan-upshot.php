<?php
/**
 * Dokan Upshot
 *
 * Dokan Subscriber Plugin
 *
 * @package   Dokan_Upshot
 * @author    Myriad Mobile  <dscott@myriadmobile.com>
 * @license   GPL-2.0+
 * @link      https://bitbucket.org/derekscott_mm/dokan-upshot
 * @copyright 2017 Myriad Mobile
 *
 * @wordpress-plugin
 * Plugin Name:       Dokan Upshot
 * Plugin URI:        https://bitbucket.org/derekscott_mm/dokan-upshot
 * Description:       Dokan Subscriber Marketing Plugin
 * Version:           1.0.1
 * Author:            Myriad Mobile
 * Author URI:        https://bitbucket.org/derekscott_mm/
 * Text Domain:       dokan-upshot
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://bitbucket.org/derekscott_mm/dokan-upshot
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-dokan-upshot.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'Dokan_Upshot', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Dokan_Upshot', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Dokan_Upshot', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

/*
 *
 * If you want to include Ajax within the dashboard, change the following
 * conditional to:
 *
 * if ( is_admin() ) {
 *   ...
 * }
 *
 * The code below is intended to to give the lightest footprint possible.
 */



if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-dokan-upshot-admin.php' );
	add_action( 'plugins_loaded', array( 'Dokan_Upshot_Admin', 'get_instance' ) );

}

/**
 * @brief   CRON task setup and required lookup functions.
 * @details This function is what checks for users and emails them to upgrade.
 */
function upshot_custom_cron_schedule( $schedules ) {
    $schedules['every_hour'] = array(
        'interval' => 3600, // Every 6 hours
        'display'  => __( 'Every Hour' ),
    );
    return $schedules;
}

add_filter( 'cron_schedules', 'upshot_custom_cron_schedule' );

//Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'upshot_cron_hook' ) ) {
    wp_schedule_event( time(), 'every_hour', 'upshot_cron_hook' );
}

///Hook into that action that'll fire every six hours
add_action( 'upshot_cron_hook', 'upshot_cron_function' );

// Weekly is a misnomer. Really a user configured value for days
function alert_weekly_update( $user_id ) {
    $alert_days = get_option( 'dokan-upshot-days' );

    if ( $alert_days == 0 || $alert_days == false || $alert_days == '' ) {
        $alert_days = 7;
    }

    // return $prv_two_date;
    $bodytext = get_option( 'dokan-upshot-body' );
    if($bodytext == "" || strlen(get_option( 'dokan-upshot-body' )) < 10){
        dbresultlog("Body text was not set. Not sending a blank message.");
        return false;
    }

    $maxID = get_option( 'dokan-upshot-maxid' );
    if($maxID == false || $maxID == ""){
        dbresultlog("No Max Subscription ID");
        return false;
    }
    $has_subscription_id  = get_user_meta( $user_id, 'product_package_id');
    if(isset($has_subscription_id) && isset($has_subscription_id[0]) && $has_subscription_id[0] == $maxID){
        dbresultlog("Already at Max Subscription ID");
        return false;
    }

    $last_sent_array = get_last_sent($user_id);
    if($last_sent_array !== false && isset($last_sent_array) && isset($last_sent_array["lastupdate"])){
        $last_sent = $last_sent_array["lastupdate"];
        $dstring = '-'.$alert_days.' days';
        if(strtotime($last_sent) < strtotime($dstring)) {
            // More than seven days have passed
            dbresultlog("SEND! More than ".$alert_days." days have passed");
            return true;
        } else {
            dbresultlog("NO SEND! Less than ".$alert_days." days have passed");
            return false;
        }
    } else {
        // Assume they have never been sent
        dbresultlog("SEND! No record Found");
        return true;
    }
}

function dbresultlog($msg){
    $dirLog = dirname(__FILE__);
    $message = sprintf("[%s] %s\n", date('d.m.Y h:i:s'), $msg);
    error_log("[DB_SQL] ".$message, 3, $dirLog . '/cron.log');
}

function get_last_sent($user_id){
    global $wpdb;

    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}dokan_sub_summary WHERE subscriber=%d ORDER BY id DESC LIMIT  1", $user_id), 'ARRAY_A');

    if(isset($results[0])){ return $results[0]; }
    return false;
}

//create your function, that runs on cron
function upshot_cron_function() {
    global $wpdb;
    $users = get_users( 'role=seller' );
    $maxID = get_option( 'dokan-upshot-maxid' );

    foreach ( $users as $user ) {

        $is_seller_enabled = dokan_is_seller_enabled( $user->ID );
        $has_subscription  = get_user_meta( $user->ID, 'product_package_id', true );
        $has_subscription_id  = get_user_meta( $user->ID, 'product_package_id');


        //$recurring_status  = get_user_meta( $user->ID, '_customer_recurring_subscription', true );

        if (  $is_seller_enabled && $has_subscription && isset($has_subscription_id) && isset($has_subscription_id[0]) && isset($has_subscription_id[0]) && $has_subscription_id[0] !== $maxID) {

            if ( alert_weekly_update( $user->ID ) !== false ) {

                $subject = ( get_option( 'dokan-upshot-subjects' ) ) ? get_option( 'dokan-upshot-subjects' ) : __( 'Marketplace Subscription Update', 'dokan' );
                $message = ( get_option( 'dokan-upshot-body' ) ) ? get_option( 'dokan-upshot-body' ) : __( 'Your ' . get_option( 'blogname' ) . 'Marketplace Subscription Update', 'dokan' );
                $headers = 'From: ' . get_option( 'blogname' ) . ' <' . get_option( 'admin_email' ) . '>' . "\r\n";
                wp_mail( $user->user_email, $subject, $message, $headers );

                $table_name = $wpdb->prefix . 'dokan_sub_summary';

                $wpdb->insert(
                    $table_name,
                    array(
                        'lastupdate' => date('Y-m-d h:i:s'),
                        'subscriber' => $user->ID
                    )
                );

                $msg = "EMAIL FOR ".$user->ID." with SubID ".$maxID." updated!";
                $dirLog = dirname(__FILE__);
                $message = sprintf("[%s] %s\n", date('d.m.Y h:i:s'), $msg);
                error_log("[DBSQL] ".$message, 3, $dirLog . '/cron.log');
            } else {
                $msg = "DID NOT EMAIL  ".$user->ID;
            }

        }
    }
}

/** END CRON  */
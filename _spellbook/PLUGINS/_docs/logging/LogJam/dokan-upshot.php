<?php
/**
 * Dokan Upshot
 *
 * Dokan Subscriber Upselling Plugin
 *
 * @package   Dokan_Upshot
 * @author    Prairie Grit  <admin@prairiegrit.com>
 * @license   GPL-2.0+
 * @link      https://prairiegrit.com
 * @copyright 2017 Prairie Grit
 *
 * @wordpress-plugin
 * Plugin Name:       Dokan Upshot
 * Plugin URI:        https://prairiegrit.com
 * Description:       Dokan Subscriber Marketing Plugin
 * Version:           1.6.1
 * Author:            Prairie Grit
 * Author URI:        https://prairiegrit.com
 * Text Domain:       dokan-upshot
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://prairiegrit.com
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

//PUT BACK FOR LOGJAM
// if ( defined( 'WP_CLI' ) && WP_CLI ) {
//   \WP_CLI::add_command( 'log', 'LogJam\CLI' );
// }

//flush_rewrite_rules( false );
/*----------------------------------------------------------------------------*
 * Load Log Jam Logging
 *----------------------------------------------------------------------------*/

//require_once( plugin_dir_path( __FILE__ ) . 'log_jam.php' );
//require_once dirname( __FILE__ ) . 'log_jam.php';


/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-dokan-upshot.php' );
//require_once( plugin_dir_path( __FILE__ ) . 'logjam.php' );  //PUT BACK FOR LOGJAM

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( 'Dokan_Upshot', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Dokan_Upshot', 'deactivate' ) );



//add_action( 'plugins_loaded', 'LogJam\plugins_loaded', 9 );  //PUT BACK FOR LOGJAM

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
if ( is_admin() )
{

//  if( isset( $_POST['ADMIN_EMAIL'] ) )
//  {
//    // Requesting a Debug Message Send
//    //return false;
//  }
  /** Adding Settings extra menu in Settings tabs Dahsboard */
}


if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'admin/class-dokan-upshot-admin.php' );
    require_once( plugin_dir_path( __FILE__ ) . 'admin/UpshotAdminBuilder.php' );
    add_action( 'plugins_loaded', array( 'Dokan_Upshot_Admin', 'get_instance' ) );
    add_action( 'plugins_loaded', array( 'UpshotAdminBuilder', 'get_instance' ) );
    add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), array('Dokan_Upshot_Admin', 'add_action_links' ) );


}

/**
 * @brief   CRON task setup and required lookup functions.
 * @details This function is what checks for users and emails them to upgrade.
 */
function upshot_custom_cron_schedule( $schedules ) {
    $schedules['every_hour'] = array(
        'interval' => 3600, // Every 12 hours 43200
        'display'  => __( 'Every Hour' ), //__( 'Every Twelve Hours' )
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
do_action( 'upshot_cron_function' );

// Weekly is a misnomer. Really a user configured value for days
function alert_weekly_update( $user_id ) {
    $alert_days = get_option( 'dokan-upshot-sentdays' );
    //dbresultlog("Recorded ".$alert_days);

    if ($alert_days == "-1" || $alert_days == -1){
        //Override Mode.
        return true;
    }

    if ( $alert_days == 0 || $alert_days == false || $alert_days == '' ) {
        $alert_days = 7;
    }

    // return $prv_two_date;
    $bodytext = get_option( 'dokan-upshot-body' );
    if($bodytext == "" || strlen(get_option( 'dokan-upshot-body' )) < 10){
        dbresultlog("Body text was not set. Not sending a blank message.");
        return false;
    }

    $maxID = (int) get_option( 'dokan-upshot-maxid' );
    $packageID = (int) get_user_meta( $user_id, 'product_package_id', true );
    if(isset($packageID) && $packageID == $maxID){
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
            //dbresultlog("NO SEND! Less than ".$alert_days." days have passed");
            return false;
        }
    } else
    {
      // Assume they have never been sent
      dbresultlog( "SEND! No record Found" );
      return true;
    }
}

function dbresultlog($msg){
    $dirLog = dirname(__FILE__);
    $message = sprintf("[%s] %s\n", date('d.m.Y h:i:s'), $msg);
    error_log("[DU_LOG]" . $message, 3, $dirLog . '/dv.log');
}

function get_last_sent($user_id){
    global $wpdb;

    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}upshot_emails WHERE subscriber=%d ORDER BY id DESC LIMIT  1",
                                                 $user_id), 'ARRAY_A');

    if(isset($results[0])){ return $results[0]; }
    return false;
}

function get_clients() {

    $users = array();
    $roles = array('vendor', 'seller', 'administrator');

    foreach ($roles as $role) :
        $users_query = new WP_User_Query( array(
            'fields' => 'all_with_meta',
            'role' => $role,
            'orderby' => 'display_name'
            ) );
        $results = $users_query->get_results();
        if ($results) $users = array_merge($users, $results);
    endforeach;

    return $users;
}

/**
 * @brief Upshot Cron function for sending emails
 */
function upshot_cron_function() {
    global $wpdb;
    $blog_id = get_current_blog_id();

    $users = get_clients();
    $maxID = (int)get_option( 'dokan-upshot-maxid' );
    $jadata = json_encode($users);
    //dbresultlog($jadata);

    //$users = get_users( 'role=seller' );
    $user_query = new WP_User_Query(
        array(
        'role' => 'seller',
            'meta_query' => array(
                array(
                  'key' => 'dokan_enable_selling',
                  'value' => 'yes'
                ),
            )
        )
    );

    $users = $user_query->get_results();

    $sentTotal = 0;
    $topTier = 0;
    $targetedUsers = 0;

    foreach ( $users as $user ) {

          $postable = (get_user_meta( $user->ID, 'can_post_product', true ) == 1 ) ? "active" : "inactive";
          $packageID = get_user_meta( $user->ID, 'product_package_id', true );

        if((int) $packageID == $maxID){
          $topTier++;
          $msg = "DID NOT EMAIL MAX TIER USER:  ".$user->data->user_email;
          //dbresultlog($msg);
          return true;
        }
        //$recurring_status  = get_user_meta( $user->ID, '_customer_recurring_subscription', true );

        if(isset($user->data->user_email) && (int) $packageID > 0){
          if ( alert_weekly_update( $user->data->ID ) ) {

            $alert_days = get_option( 'dokan-upshot-sentdays' );
            $subject = ( get_option( 'dokan-upshot-subjects' ) ) ? get_option( 'dokan-upshot-subjects' ) : __( 'Marketplace Subscription Update', 'dokan' );
            $message = ( get_option( 'dokan-upshot-body' ) ) ? get_option( 'dokan-upshot-body' ) : __( 'Your ' . get_option( 'blogname' ) . 'Marketplace Subscription Update', 'dokan' );
            if($alert_days == "-1" || $alert_days == -1){
              $subject = "DEBUG EMAIL (-1)  ".$subject;
            }

            $headers = 'From: ' . get_option( 'blogname' ) . ' <' . get_option( 'admin_email' ) . '>' . "\r\n";
            wp_mail( $user->data->user_email, $subject, $message, $headers );

            $table_name = $wpdb->prefix . 'upshot_emails';

            $wpdb->insert(
              $table_name,
              array(
                'lastupdate' => date('Y-m-d h:i:s'),
                'subscriber' => $user->data->ID
              )
            );

            $sentTotal++;

            $msg = "User: ".$user->data->user_email." ID# ".$user->data->ID." has been emailed!";

            if($alert_days == "-1" || $alert_days == -1){
              $msg = "DEBUG EMAIL (-1) | ".$user->data->user_email." ID# ".$user->data->ID." has been emailed!";
            }
            dbresultlog($msg);
          } else {
            $msg = "RECENTLY ALREADY EMAILED USER:  ".$user->data->user_email;
            //dbresultlog($msg);
          }
        }
    }

    if($sentTotal > 0){
      $stats_table_name = $wpdb->prefix . 'upshot_stats';
      $seller_counts = dokan_get_seller_count();
      $wpdb->insert(
        $stats_table_name,
        array(
          'lastupdate' => date('Y-m-d h:i:s'),
          'total_top_subscribers' => $seller_counts['active'],
          'total_nottop_subscribers' => $seller_counts['inactive'],
          'sent_emails' => $sentTotal
        )
      );
    }
}

/** END CRON  */

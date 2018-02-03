<?php
/**
 * Created by PhpStorm.
 * User: derekscott
 * Date: 11/26/17
 * Time: 11:22 PM
 */

/**
 * Helper function for standard Wordpress Message Logs
 * @param string|array|object $msg what we are logging
 */
if ( ! function_exists('write_wp_log')) {
    function write_wp_log($msg, $admin=false)
    {
        $dirLog = dirname(__FILE__);
        $message = sprintf("[%s] %s\n", date('d.m.Y h:i:s'), $msg);
        if(is_file($dirLog . '/dv.log')){
            error_log($message, 3, $dirLog.'/wp.log');
        } else {
            error_log($message, 3, './wp.log');
        }

        if($admin!==false) {
            $class = 'notice notice-error';
            $message = __( $msg, 'dokan' );
            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
        }
    }
}
/**
 * Helper function for plugin specific logging to file
 * @param string $msg admin HTML displayed Message
 */
if( ! function_exists('dv_html_error')) {
    function dv_html_error($msg) {
        $class = 'notice notice-error';
        $message = __( $msg, 'dokan' );

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
    }
}
/**
 * Helper function for plugin specific logging to file
 * @param string $msg message to log to file
 */
if( ! function_exists('dv_log')) {
    function dv_log($msg)
    {
        $dirLog = dirname(__FILE__);
        $message = sprintf("[%s] %s\n", date('d.m.Y h:i:s'), $msg);
        error_log($message, 3, $dirLog . '/dv.log');
    }
}
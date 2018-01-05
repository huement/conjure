<?php
/**
 * Plugin Name:     LogJam
 * Plugin URI:      https://github.com/tarosky/logjam
 * Description:     A logging plugin.
 * Author:          Takayuki Miyauchi
 * Author URI:      https://tarosky.co.jp/
 * Text Domain:     logjam
 * Domain Path:     /languages
 * Version:         1.0.3
 *
 * @package         LogJam
 */

namespace LogJam;


require_once dirname( __FILE__ ) . '/vendor/autoload.php';

//require_once dirname( __FILE__ ) . '/log_jam/LogJam/autoload.php';


if ( defined( 'WP_CLI' ) && WP_CLI ) {
	\WP_CLI::add_command( 'log', 'LogJam\CLI' );
}

function plugins_loaded() {
  //Registers post type `logjam`.
  $post_type = new Post_Type();
  $post_type->register();

  //Registers admin panel.
  if ( is_admin() ) {
    $admin = new Admin();
    $admin->register();
  }

	/**
	 * Filters the array of default loggers.
	 *
	 * @param array $logger_classes An array of classes of `\LogJam\Logger`.
	 */
	$loggers = apply_filters( 'logjam_default_loggers', array(
		'LogJam\Logger\Activated_Extensions',
		'LogJam\Logger\Delete_Post',
		'LogJam\Logger\Last_Error',
		'LogJam\Logger\Post_Updated',
		'LogJam\Logger\Updated_Core',
		'LogJam\Logger\Updated_Extensions',
		'LogJam\Logger\WP_Login',
		'LogJam\Logger\XML_RPC',
	) );

	foreach ( $loggers as $logger ) {
		init_log( $logger );
	}

	add_action( 'rest_api_init', function() {
		$rest = new Rest_Logs_Controller( Post_Type::post_type );
		$rest->register_routes();
	} );
}

add_action( 'plugins_loaded', 'LogJam\plugins_loaded', 9 );

/**
 * Registers the logger to the specific hooks.
 *
 * @param string $logger_class The extended class of the `LogJam\Logger`.
 */
function init_log( $logger_class ) {
	if ( class_exists( $logger_class ) ) {
		$result = Event::get_instance()->init_log( $logger_class );
		if ( is_wp_error( $result ) ) {
			wp_die( 'Incorrect `LogJam\Logger` object.' );
		}
	} else {
		wp_die( '`' . $logger_class . '` not found.' );
	}
}

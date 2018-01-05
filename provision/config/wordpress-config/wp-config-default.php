<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_default' );

/** MySQL database username */
define( 'DB_USER', 'homestead' );

/** MySQL database password */
define( 'DB_PASSWORD', 'secret' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '`dqE+awL-_`n_t>:Tmt>h5dH[Mq*xXhCIWV&w:B><lDltX?VcmyK#5Y;WIHPki;N' );
define( 'SECURE_AUTH_KEY',  '^)blFP!zlfhr.-:o=rjN|Kts#W`vms<2 OQwQ]cYxk+r6t(hT<jb4&i-@z{)aj]8' );
define( 'LOGGED_IN_KEY',    ':&Ho/lYA+&i_M){gLC09A[A~F)~b$^R(Wu280C]X~b*k`cK?&m&$J%wVS!)D0CT1' );
define( 'NONCE_KEY',        '_D)2LO %E8CB.(MX1|DA^`?2E5EL1Cd 9!c6U7-tV&$kOGxhl-dsq}|FS=zZqc;I' );
define( 'AUTH_SALT',        'kTz$if*~5m&/Ph{YKd=T_+(*3-UXyk>ZVz#n%FP.s=o21Y,xy$Qyb49 #}LuZkxW' );
define( 'SECURE_AUTH_SALT', 'p!D:?P!HJ#-FKTFk2-uNR>I&D(Y,E[nB}^JZq]bAdy#.~a}_I!;k|zj hLoI1kR3' );
define( 'LOGGED_IN_SALT',   ';t70ntUvZdtf5=X|byL3`:hLJ=Jtq+4BrP{KKT#DIWx(y<HW^%bw`%n%|05yu;uR' );
define( 'NONCE_SALT',       'k[D4qpR)|lJ(+sDRVe{evda{[d6LBS~6Kiyi}Xo_Z(_s8_]4,TQyb_%{TMV30C=x' );


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


// Match any requests made via xip.io.
// define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] );
// define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] );

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG',  true);
define( 'WP_DEBUG_DISPLAY', true);
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );
error_reporting(E_ALL);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

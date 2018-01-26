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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'homestead');

/** MySQL database password */
define('DB_PASSWORD', 'secret');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@-*/
define('AUTH_KEY',         'l;Aj3`0zAuB&|`OP-,MLtaqH,T/TRrrG)[O(+2B2T?Pw@8<<nh|.kN>b7D7.%)(-');
define('SECURE_AUTH_KEY',  '4dWIDKxt]XGg&`8i0%fNWdb}lo7}4!*KE3$(2 QG/|0ViK{lbj(u|U3Rxe?G8<=m');
define('LOGGED_IN_KEY',    ' [*k*ZusZW_6h=lPjHWB5lB?OI/yL$d>V_@% q~K@`qR`9bOHC9QH.,|l|r;Z+CH');
define('NONCE_KEY',        'hkRvRx3L-tOPSmzk+/ryfsJy%{0 %W(vCv>+K-PV8Gs^*p&D%$Xy11-[?#%4>M~G');
define('AUTH_SALT',        '73axU2n{$_a@o-,Idg_.mX>|@:Pg68`ntS6T!N(os`F/^N<_gBLdLT!ZIkM-k<:i');
define('SECURE_AUTH_SALT', ' {n+<Ga~w/QNP(e9+#+V;xgn3=V~sf(4~?F;g(]Z)u*HF[K),Dh9EKa-?3%*7}Q.');
define('LOGGED_IN_SALT',   'aoic6)Ea2*PHzO)k|J$#VPY{X+Xd_9d|6mNK2;+;EMa@psoF4O8PyXp,iyL-4YH>');
define('NONCE_SALT',       '4ikbMi(Ln%~#6+xZX&EN+vvv8%{cyCWmOEA&;og,1+0.D5L]6+bE{$ND+3Y|1(Fe');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpmm_';

/**
 * Advanced Options
 */
define( 'WP_POST_REVISIONS', 3 );


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */

define( 'FORCE_SSL_ADMIN', false );

define( 'JETPACK_DEV_DEBUG', true );
define( 'WP_DEBUG', true );

// Don't use this. Instead...
// define( 'WP_DEBUG_LOG', true);
// Use This
@ini_set( 'log_errors','On' );
@ini_set( 'display_errors','On' );
@ini_set( 'error_log','/home/vagrant/log/debug.log' );

define( 'WP_DEBUG_DISPLAY', true );
define( 'SAVEQUERIES', true );
define( 'SCRIPT_DEBUG', true );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

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
define('DB_NAME', 'eduknl1q_mwp');

/** MySQL database username */
define('DB_USER', 'eduknl1q_mwp');

/** MySQL database password */
define('DB_PASSWORD', '1qazxsw2');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'jriH/j-Y`EPZ?-p.|A0/_|kI~DlsrI RUPLFJ+7)~|NegiupSk6sq U~)Kt-!wMr');
define('SECURE_AUTH_KEY',  '$UG.~P71t[hhC`.ic5b5HPr[k@:tH+X;Klz&#{ncS|le`CXwYRI|wMQsT% Jw2Hx');
define('LOGGED_IN_KEY',    '%7k3On5+(e@xJme#&FS`ApbU44E]3,X#B;vzaU]+y7aQq?J>y+X^{*f8+n|4BN}2');
define('NONCE_KEY',        'wq=52~{-jrCEz1MzJ!(Qwa8tlbm7]&qw*{iq)>&W~12`)C}wFRcOyI+[k}[hO{RJ');
define('AUTH_SALT',        'H>4S+ w+c>Rw<1&v@L+0N!mo:G0B:0dSqoe-*8 +#<+6F*-|-96e&tRqHL&r%?^;');
define('SECURE_AUTH_SALT', 'G|xe}s6[f-,-!m|#5+u[>t>@}1 6^}BPVskrg=dPn[uiEhq-]#%PO`qw|J:L/rO.');
define('LOGGED_IN_SALT',   'IqTb])H$`P_-riLj$)</Kwd9 _Y|$hyN%%iNiT,XNrVIzC;|vb.u*k`T,-`-YC~g');
define('NONCE_SALT',       'wbWVsh@IoRh zC*[e4wS&/a|T(n9I=~)v:yYF+L*S~,1hP`=-+6HvY> 6 OU%r._');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'm_';

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
 /*define('WP_DEBUG', false);*/
// Turns WordPress debugging on
define('WP_DEBUG', true);
// Tells WordPress to log everything to the /wp-content/debug.log file
define('WP_DEBUG_LOG', true);
//define('WP_DEBUG_LOG', false);
// Doesn't force the PHP 'display_errors' variable to be on
define('WP_DEBUG_DISPLAY', false);
//define('WP_DEBUG_DISPLAY',true);
// queries loggen
define( 'SAVEQUERIES', true );
// Hides errors from being displayed on-screen
@ini_set('display_errors', 0);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


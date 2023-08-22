<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'secman' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Y1Wg8qaXur.7Z!FK2%,d_e4n9B7]P8b<qJWWG4UTN^V#(H-5d67p-f<RMwm&XA<U' );
define( 'SECURE_AUTH_KEY',  'H^ESNF*d!=_]:6;*sJ9=/!z03]ej9&F*<+RR*^&_64&t@gBwViAB=o]vE/EPfN O' );
define( 'LOGGED_IN_KEY',    ';.~$V>WPtMz2:=89${|]I@?Amu>fX.Bx6qb)WPKE;YrWUjZQrLzw}4-fuwE8Qs<y' );
define( 'NONCE_KEY',        '$s#;tThh$2C*.STmFfG2G4<YSM}*W3d#*va>>Z#UrXuNHu>0dWP7sm0rauUK;|2b' );
define( 'AUTH_SALT',        'Pc)qv}8BC(0d)c{Z0?Tb$wny1683L+v3QY7S)LBHF(kkpB)!7f+t@,Z~e_ya@$hZ' );
define( 'SECURE_AUTH_SALT', 'shjP!rMOx<QtFzZMV{dT{sU$rk5Dc[At14Le U:zcfwzm.8t!q-1AW|oJBSAbYuy' );
define( 'LOGGED_IN_SALT',   '(A5%%n[Bg (x~-QMh65BgA-Wj$Ti)JRZFwYr7fOH1[Y3d!$%cE]@`Hfua4$c0DlF' );
define( 'NONCE_SALT',       'Ri[_Q%f}bCrJ9Ol.LfUuTvwg)Jm8U`x~n5h)ZV}zenIHaY%Ic$DT68WIMR|_X@7c' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_sec_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

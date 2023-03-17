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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp-site_prueba' );

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
define( 'AUTH_KEY',         '!hX#v0|YDCUmeQY.zUvek<yMQN/7; B`9NG*hl~Wsk-|C,[^b8-_F,c4Hz{^lt_L' );
define( 'SECURE_AUTH_KEY',  'vm)vrTlxmaAt$D5)5J834QO|cen$IH5o4+G((e>k#+}~Ps?e{X/l3Gr+Dq)Mh<>m' );
define( 'LOGGED_IN_KEY',    'J3Cf+Y%Wo>ibHQ[*a}Mv!t5hBH$&|!=r0~s?7$.ba146;HYG4a@_q3i$4G8iHv2f' );
define( 'NONCE_KEY',        '93e7w^K5i!N1c:ovkbcY{>1.zA:@o{xu}*5aa(rSLkS7(q~Dn/ZFnsPN5Om;?,Dr' );
define( 'AUTH_SALT',        'S#oUfOfEf>(_%RL[<9m<^v?Uv5zyw]Y69[Ca]=?NLpBZt>d$Ww6exW*_%vOo4tuZ' );
define( 'SECURE_AUTH_SALT', ' mtf|vRz,;Rrqj-LoA.Ljk{hU1uf1dM#5@[wJ_5xv;r*fMe}?#.ej$.)$mEJg.bu' );
define( 'LOGGED_IN_SALT',   ',7}n=KtVpjLW% b{azB*`Ig8x5-cWYpVtB>(s/2!_)I#^tgW|l[Co9=!T]mZeEyD' );
define( 'NONCE_SALT',       '{)kcT=~Gsug:yVJV;b@M>ko[ju~ZyO]u$3|q&,kO8C=N@kGzhANGMYM2`3}hmt^h' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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

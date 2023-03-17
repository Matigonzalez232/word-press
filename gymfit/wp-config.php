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
define( 'AUTH_KEY',         'AE}~_* {^k6Fkd#`Ab0:Z5Q(WU$q!PC#0F2%Z@=tZcW`lyaCN&YTPgMjV@oqV%I<' );
define( 'SECURE_AUTH_KEY',  'lfp*-7Dgjf+k!TS_GQ8$*a}@W+CO|-3yt*l9>kF0_&E`Fi=vn=d?e,{0Q4HqbP;,' );
define( 'LOGGED_IN_KEY',    'zYwDb:7%X>*VZ_B4u)?Hj(6r*PO]CY Gk2$0r;I,K`vYr(utmCu[eXVP FahKY3[' );
define( 'NONCE_KEY',        'B,=ipf@3mCn:ecnk^fReIysUQpp>AKcH=s&):,Q>[FC{QY;xpBEJ^jyKrUun]5wI' );
define( 'AUTH_SALT',        'b_f6vYT3Ob@2k5!y:ecZvCW|R.,!nLMHebf(#[pD2?eT`@]B$]% Ncq$79/#ExI>' );
define( 'SECURE_AUTH_SALT', '_FP{#3H^}VF`2}ks5Z;Y&^AMlEYf>fVqVMz(#*E-FH]oBrw__eSwDMr2{MwK+HUV' );
define( 'LOGGED_IN_SALT',   'X<s,n{O_sc(%w2O`pDPU>}`4F8O[^Cq<G~K3+}6+R5*Ei$q]!]3& MX =fgHX0n#' );
define( 'NONCE_SALT',       '~ILC/G~UN_%ZaC.|ANba@#i{m8E-!nAQE+=6jU3PA1<Ac(]pjt5Q=_utE/dD2)zs' );

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

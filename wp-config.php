<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'testwork5567' );

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
define( 'AUTH_KEY',         '!R7X K7@plA[2&GZ4V9HP%[NPcxOH6lc^eVZtmui6.Xk1>9G!)u?{mf-Saf]V~Qr' );
define( 'SECURE_AUTH_KEY',  '~S-L<#.nqZ*Wh DMe5$$bwr5@s}$0X9_PI_@<bv?Yeu7{_9A}8oF^_`*y6j5Z{MP' );
define( 'LOGGED_IN_KEY',    'gUcSvfJXccYfcflG+Ap0:zgtdK(bwG2d_I[tn[jQ]&l_]TVL5mra6<V^}C+KFUSo' );
define( 'NONCE_KEY',        '7H5gA4f5yhnJ!SYnznW-g#,Q:4r+39TCKb}8}*{ceEX`yjlF9&f:1-(XY:{yh9Br' );
define( 'AUTH_SALT',        '#Ht(,<l#|.Dx8IME`oPW2LRn1=Q>0#SEK/N7V#f,5tb*LqDor[V7R)hr#s,OR)T<' );
define( 'SECURE_AUTH_SALT', '(yywou*8PAJ2f%B5/ (W9PY2i*$I<((|Y*LBv^@k@v2]ZhnS_{vH4((}BKuLp-5?' );
define( 'LOGGED_IN_SALT',   'h3ZpPl=Cl>Jxd(uMiA[eBtA{w{&`Dh3#e_Jv^,aB;X6EGcj}/I6s}0:yfq|dqp;L' );
define( 'NONCE_SALT',       'tT@y<9KTXF+HEGgQFWAur ;s28 vE;f=[(SH~+pV=d0Mtnj(G,3m#K4xz(:N/=Lk' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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

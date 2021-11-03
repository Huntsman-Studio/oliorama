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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'oliorama_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'x@Gt}3pTSivUL#z7B}?]GqKXUliRi2M8G=iY VYNTQh;L,)$G|Gk5xy;@uuETv[K' );
define( 'SECURE_AUTH_KEY',  '7m&x*9AYeV&+L@g$m7v~!@be!83zS4|F7i:f(7Jx@KJ_eP64Be8KdJg S*@f.Y0b' );
define( 'LOGGED_IN_KEY',    'mx@X&`tUKUwuyiK*vul_zatH*<+*sn4+O1d{qm_eH||fViXg],`a14gB`cwe`[cE' );
define( 'NONCE_KEY',        'q< kiSTaZ%I(Crz$Ia3M;15Yfv}_S-ytn+W_4vuvBtxDHF^^HNeuHbMr?Qkb5tA&' );
define( 'AUTH_SALT',        '`K+J;#+j~a++l;Mr_7mr#$N>TK)*m/rE+mj{30msvs$b;t^r65^?14pJ>5,xLiw<' );
define( 'SECURE_AUTH_SALT', '{w.?O*J+*7LK<mBuQ?3Z)t>%!7u)4d9=^vs!_(1Qk0@}TjdKyku1VU2 O-q??5zE' );
define( 'LOGGED_IN_SALT',   '%8TzLnI@;qmi;2o2q*cK+x4>wDMf#<EBv][s*tm/1R(v* {w-bW6=?AHd2,]moDY' );
define( 'NONCE_SALT',       'N7l $WLa$7>)g,:)<}]~cR)iC?J#_* R<?6qu5)jpyZD|H3=H#u>oA Av4RB,qYs' );

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

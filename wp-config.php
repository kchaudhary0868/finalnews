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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         '8qe1I#S?Nd`C71xg-`7--#?^#(a(R}t &$1} y5~~s;cWw{iC/1bP>Q)pu7HbXu}' );
define( 'SECURE_AUTH_KEY',  'V8g;?Ur0EQl8|dq0N.)1:vTSbQF3nxWx}h4@b$?_Fu!v)v(aB5A`%=_LLg0o~ff`' );
define( 'LOGGED_IN_KEY',    'l~xrYh)t*.d:9z*>`KtjyQukl%)b>5nGMDXJ^GLU)%vPqDM%+Ik;+>Dk6~rH/OkG' );
define( 'NONCE_KEY',        'S,`C8~m`K)Rf).s:y&><pKINW8><Vx0!M-2nZR$@*p_zh(sS4T5G)O@!``Cg,muG' );
define( 'AUTH_SALT',        'L97qee1-dmW$8(`jj^c;JC!]!!>C4W8-PQpkIUjD-9pq)A;]+^EZpizcNqI#9Ow|' );
define( 'SECURE_AUTH_SALT', '|WjEW]x5:-<DZGe!wY(KH!gwbx92U<!j:d|G.BFc)zG(Dr_c,g8BL/%fBdmNyV&i' );
define( 'LOGGED_IN_SALT',   'i=yW7|;B#t5GH?K9-z{!Vit;T2Oss${ */057#g,bL+cmh`Cd FDUL jU(sV91!_' );
define( 'NONCE_SALT',       '+zOZ#:2$mn4yXIwKY!:P*kXc=jRny~QIP|QD`&kaC|Rbgr!9;/-PRoW+QME*_`k&' );

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

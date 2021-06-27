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
define( 'DB_NAME', 'ghar-grihasti' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '|Yo^D-#RR=;R*(|LUE`ML|1f$0-*G~W~Xlr$a|pe4P}u8b)u[XtEH<XfZ,<?h2D(' );
define( 'SECURE_AUTH_KEY',  'f5)C9Rcq?OPz=/xKK%>[VznrqX7V;$<f]=.TV1m|]&o3$xv%i-u]3$o!,:dO1HR ' );
define( 'LOGGED_IN_KEY',    '!C85$d_9*)P3^qT2|xY=8.uvLwyP ZCJlH0%b+W7!mN4UO8!5WiFAn2NX+.HBqP!' );
define( 'NONCE_KEY',        '<owR41_(]$gOl&K4,u^$.6)|yk Q:*V.kPSE@28hWn?aim8x9riY<u/,ng(Ay*hS' );
define( 'AUTH_SALT',        'J?ekwQqB59v;vvM[:fO+.&[6_=H$[;S&UNjcf>dGzu)m?A#wh--Gi1`kG^72h(jD' );
define( 'SECURE_AUTH_SALT', '6a[W@v*b[?|i|?+{$KH#MmMKzfa1$LPF? 2]m1g P^Y5.lIa.]8#z[LuOoDCSK~.' );
define( 'LOGGED_IN_SALT',   'Bh6lBkam10I#HkLcwO~UR[}5cVdEf->@r8u3<r]:vLoaw@.+9QSx~&y}>h84COvo' );
define( 'NONCE_SALT',       '=KEueK3p#:G6dgkr`nv^]q4%aYN*&8n]^mjvslXi9qtnjR4BWs}.2R).y`6&JCpq' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

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
define('DB_NAME', 'whisq');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'Q?*s<_hiWT{!XCG ]}}+y4h;AxJnSVhak[#^*B#Z[&0iFUXPg(yd@FG,h$3[OdM!');
define('SECURE_AUTH_KEY',  'w=z==di}k#;970bU[:kQGpW:oWixb>b:M@DibJNI;m9_*SFV4#h8_<vZB)IPe2M~');
define('LOGGED_IN_KEY',    'F^&YzIiIc]?%5I/fA:BiJ7 8ibcGL59Dgc.M@-:0UybUNU[=90_WNa2h|M}0bxI$');
define('NONCE_KEY',        ' 4;Y(q/SU.OZD~o`r@*>@OF Tj$!Srw`>:>9Qq-{}VQ/m]kEa[&zi(v<A2vLZ  X');
define('AUTH_SALT',        'aBv{iE)}DC63*i~aJMFh3}Mb/Ixs;&_}}2TY9j!O f6Y;HeE&5!FH(WW_oF&FgTP');
define('SECURE_AUTH_SALT', '%DbCol|^D^E5!V|h0Fqfl&-Nyd#==7Ds@Fxd[?2&bDm&MJPx{R7aI bldLSQM%lM');
define('LOGGED_IN_SALT',   'd?(%O;4}IR4^Q~]{D#^/J(J@6FLz=m0cmF`d%^VR%l/f]y4[g52ROYpRm{F)Z)fU');
define('NONCE_SALT',       '}T3}9l;18&I^JTH04m$Tri#pteJ8mACf{3`d7Npfvf}u74B5qXhg:EW=n1gprrJQ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

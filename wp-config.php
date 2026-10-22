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
define( 'DB_NAME', 'brokermojo' );

/** Database username */
define( 'DB_USER', 'dbmasteruser' );

/** Database password */
define( 'DB_PASSWORD', 'brokermojo@!@#$%' );

/** Database hostname */
define( 'DB_HOST', 'ls-437f8bb381fb1f11424f0113eb1331986cc03835.cpe6aiq4un06.ap-south-1.rds.amazonaws.com' );

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
define( 'AUTH_KEY',         '(1{e6@h%7%0srg#k-~g*1{^rx&UL#:3^AyV>Hog~lr+DN988b12~b~_(5C0j4L%w' );
define( 'SECURE_AUTH_KEY',  'gX{4|h4(oX& ]6#YP.V},>T3$aY7H^hWk)DhZ=&XKBhjtW8Iq#x kMnBik1{<O&v' );
define( 'LOGGED_IN_KEY',    'Aidg8_dq8TeY{ig,Uzo_jXNpa9h94Qnhu!s%;oo}<|c%T(/CBDopM/9UH=0SM /?' );
define( 'NONCE_KEY',        'fHsRpz+Ue}5w>q4X5sD~?*2]C@u~#N2v<1W^cilI0,)Rk;n4a}ADw-D~KElwFw^ ' );
define( 'AUTH_SALT',        'Zo5Sm.pXVleOsOM;ig4W-60~$BSm)yY-`yWVcX[1WN`oi0f}o@7O7-dU4t(mS$1f' );
define( 'SECURE_AUTH_SALT', 'U>y-FEu_YpydZ_+!ykdLAR+(9n17J.aP_7di%xb4bV`I+mHJo^<U=O 150 V4.T.' );
define( 'LOGGED_IN_SALT',   'J:j6C2*;#R<R1,`b8Hm+TnTUXEx9TA/UpDyiH_M&.si{PawBI.AL}ALU5*teEmw%' );
define( 'NONCE_SALT',       'Nz5C9y5?9E2NUh]UY#FJ.<,4]uI<A=z[N$ }}=~FqR@xM|ABi!IF0v0_j^l(z~CT' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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

define( 'FS_METHOD', 'direct' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */


$mysql_string = getenv('CLEARDB_DATABASE_URL');
$mysql_url = parse_url($mysql_string);

$c = mysql_connect($mysql_url['host'], $mysql_url['user'], $mysql_url['pass']) or die(mysql_error());
$db_name = str_replace("/", "", $mysql_url['path']);

define('DB_NAME', $db_name);

/** MySQL database username */
define('DB_USER', $mysql_url['user']);

/** MySQL database password */
define('DB_PASSWORD', $mysql_url['pass']);

/** MySQL hostname */
define('DB_HOST', $mysql_url['host']);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'w*]aA8B0A-,2eOR);( >lS+C*Dnr(!-z&k40b2r5*Z-OR?(;u?r:,#p{k|Ty(d*.');
define('SECURE_AUTH_KEY',  '?inr-CbM$va3dLhU6`%O<!RK;VH4D}gJa_}CYqf?/2tDAi8[L+t8nM8(Dma0BiX!');
define('LOGGED_IN_KEY',    'XOgyj,gji8G-,R=xWlGd5>cJ7%w&d!Jbc_Cbg5eK.WF3+j-O?$%+%,YYbo[]QT+a');
define('NONCE_KEY',        '5-*z..9J5@O7FhgeTcF=Bvt(m#i:.:r1pv.K)|uRreo{g,q*W?c5Mn&g<;qMPDET');
define('AUTH_SALT',        '4<_p@F&$8n43|x!!z-J 8:h=9I?B^Xhwe:<Z`<a}+=f6JG{th>;XHt!/$u;2;Ytd');
define('SECURE_AUTH_SALT', 'TR amYxW!/gC}.}uf/LZ1(v45}4n-c>Njo.~VbD 5oi:RC>c~A|Zm]Hc]EtGgP/A');
define('LOGGED_IN_SALT',   '>8<qHMd[L<<Qk<q{X<y4H7Yz_P|xf~zeIC!W*NZXjvLAKy|)5O1$m_l9cM+}6N*+');
define('NONCE_SALT',       '=-;wSDV/3we<:r?GuP>So9Dcws~]*!2DS  p:u?Z?J9/K=TSUuvM{I0kmSk#8-w1');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

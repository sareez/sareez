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
define('DB_NAME', 'hbanfvqkdv');

/** MySQL database username */
define('DB_USER', 'hbanfvqkdv');

/** MySQL database password */
define('DB_PASSWORD', 'tXySfqDmQ3');

/** MySQL hostname */
//define('DB_HOST', 'localhost');
define('DB_HOST', 'localhost:3306');


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
define('AUTH_KEY',         'DD~AWh}p>f?0nz`7slX|F.EhXkv3feUli?0`_j aD%s-mQ9 T$-cZjD4{:vp08|m');
define('SECURE_AUTH_KEY',  'u,[+!,C+oaHm>K+a)/II;LW3tBt|p+&WFJV5o :n+3/ej@A5=`)#;]`*Uchop9$S');
define('LOGGED_IN_KEY',    '}T,B6fEQ~k]7?a%!C)qpN,]U1nL.gZ3MT9}V5_f+};Oh tPVR-Gx(DM+e-83+l#H');
define('NONCE_KEY',        'KfP?Kb@*FkP.;|rmNGI6#a=)B+9/_-(>b^&F|-TcT+zORdv2H6zdtB0{A&!(RgEF');
define('AUTH_SALT',        '5&l1uBIRVnVh-Wp5/rX/%NCqQdcsK;^k0#U:}bi_Cn%N@UQPzZ8IB_E#-F4~=[6.');
define('SECURE_AUTH_SALT', '`J($=P.72Z/@3Te-Kj5P Jy-1~Js=rP^3~rIH4C xZh0}tw:j`ZD>@^USe}mFkW>');
define('LOGGED_IN_SALT',   'V_$8q*B]_oGQ6Vr.qpv!h83/f_!Kq@#s`!ozdE-_y3kS#i?W`a^<n)hfd|6#-a+ ');
define('NONCE_SALT',       '7e43JGWNRPG@o;0I|m(6mqhkM4$O{/XGpUg?1l?D]7r1L:: vdKC,UG+]^-!P22d');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'srz_wp_';

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

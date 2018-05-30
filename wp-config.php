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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sandbox' );

/** MySQL database username */
define( 'DB_USER', 'wp' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wp' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'A74eg#Taq.Bor  nap1DcuKAlx,Y_T1#}IZ`t9x45z^uafV[9cEO8]Nptx)*@v[N' );
define( 'SECURE_AUTH_KEY',  'qv8:b)eWwKT=+i;NBS)0#;o$a~9Z[A=A1M~pgH3VY!JL(Md4S<M%O6H10iOvfx@a' );
define( 'LOGGED_IN_KEY',    'r~7@T,q8evnJTGf}Y`OelEJw;;^8@Uwf;t[^xy!2ZNefhFZ5!?<Y!PE-($!0vnhk' );
define( 'NONCE_KEY',        ':8QqV|.dJI,Y%j3$?0Gz;@q_f8qC[Xo-a!ZS:hQyWxMuG(*d*,Xo]y6v6*mVk/{V' );
define( 'AUTH_SALT',        '0UaGa[Iprm%N;|8z4*h[-0,e]6([A2]P4mUEcy?5|avCML=;#dERA~`d:J=,PT,1' );
define( 'SECURE_AUTH_SALT', 'kpo. lhsa=kb7#dp,pz J,H&:D+Q:ixl%~Tx&Es>)]&MlXuq4[I#)F4tJmQegky`' );
define( 'LOGGED_IN_SALT',   'O{cfU=C[e WaU`XE*ZY`mk#d~;R%*%?PsGDu]16L)m,J:>7Ih)c }uyh0aJHO8J&' );
define( 'NONCE_SALT',       'PI^tIkqf#uGJ(.J&}}hIo40?6:b-nV[&bgt0. ?v6wi].[lXavryn4h4!r)^-pA%' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG_LOG', true );
define( 'SCRIPT_DEBUG', true );
define( 'JETPACK_DEV_DEBUG', true );
if ( isset( $_SERVER['HTTP_HOST'] ) && preg_match('/^(sandbox.)\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(.xip.io)\z/', $_SERVER['HTTP_HOST'] ) ) {
define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] );
define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] );
}


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

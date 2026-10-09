<?php
/**
 * The base configuration for WordPress - Nhom C FIT TDC
 * Dockerized Environment & Dynamic Domain Support
 */

// a helper function to lookup "env_FILE", "env", then fallback
if (!function_exists('getenv_docker')) {
	function getenv_docker($env, $default) {
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		}
		else if (($val = getenv($env)) !== false) {
			return $val;
		}
		else {
			return $default;
		}
	}
}

// ** Cau hinh Domain dong ho tro ca wordpress.local:8080, wordpressc:8080, localhost:8080 va IP LAN ** //
if ( ! defined( 'WP_HOME' ) ) {
	$proto = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ) ? 'https://' : 'http://';
	$host = isset( $_SERVER['HTTP_HOST'] ) && ! empty( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : 'wordpress.local:8080';
	define( 'WP_HOME', $proto . $host );
	define( 'WP_SITEURL', $proto . $host );
}

// ** Bypass FTP prompt khi cai dat demo, plugin, theme ** //
define( 'FS_METHOD', 'direct' );

// ** Database settings ** //
define( 'DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'wordpress') );
define( 'DB_USER', getenv_docker('WORDPRESS_DB_USER', 'wordpress') );
define( 'DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'wordpresspassword') );
define( 'DB_HOST', getenv_docker('WORDPRESS_DB_HOST', 'db:3306') );
define( 'DB_CHARSET', getenv_docker('WORDPRESS_DB_CHARSET', 'utf8mb4') );
define( 'DB_COLLATE', getenv_docker('WORDPRESS_DB_COLLATE', '') );

/**#@+
 * Authentication unique keys and salts.
 */
define( 'AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         '41743935f3ebcde19f48a1ca4862f95118e7efc4') );
define( 'SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  '394b736dcb012a8313f05853cd6911adad91f41f') );
define( 'LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    'cafa56dbdae6e87c11f87839e77281a85556b843') );
define( 'NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        '72486873329754d19f955e82171e0d05362ac426') );
define( 'AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        '7544c8be5e54ca8e6baefdbef8c8ad2cc9d8926e') );
define( 'SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', '0ed05916413549a007d8862f04de902b0c2f3918') );
define( 'LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   'f329cdebe5e2af82e86a2e80de1b10d51b246a7b') );
define( 'NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       '60830af9dbadf3e8ddb704d30a6da66af6308312') );
/**#@-*/

$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');

define( 'WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', '') );

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
	$_SERVER['HTTPS'] = 'on';
}

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
	eval($configExtra);
}

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';

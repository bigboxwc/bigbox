<?php
/**
 * Do not modify this file.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Bootstrap
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Current version -- automatically updated on release.
define( 'BIGBOX_VERSION', '%BIGBOX_VERSION%' );

// Minimum PHP version.
define( 'BIGBOX_PHP_VERSION', '7.0.0' );

// Do not allow the theme to be active if the PHP version is not met.
if ( version_compare( PHP_VERSION, BIGBOX_PHP_VERSION, '<' ) ) {
	add_action( 'admin_notices', 'bigbox_php_admin_notices' );

	if ( current_user_can( 'switch_themes' ) ) {
		switch_theme( WP_DEFAULT_THEME );
	}

	return;
}

/**
 * Output a notice that the minimum PHP version is not met.
 *
 * @since 1.10.0
 */
function bigbox_php_admin_notices() {
	/* translators: %s Minimum PHP version required for theme to run. */
	echo '<div class="notice notice-error"><p>' . sprintf( esc_html__( 'BigBox requires PHP version <code>%s</code> or above to be active. Please contact your web host to upgrade.', 'bigbox' ), esc_attr( BIGBOX_PHP_VERSION ) ) . '</p></div>';
}
);

// Composer autoloader.
require_once __DIR__ . '/bootstrap/autoload.php';

// Custom template loader.
require_once __DIR__ . '/bootstrap/template-loader.php';

// Start things.
require_once __DIR__ . '/bootstrap/app.php';

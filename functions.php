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
define( 'BIGBOX_PHP_VERSION', '9.0.0' );

// Do not allow the theme to be active if the PHP version is not met.
if ( version_compare( PHP_VERSION, BIGBOX_PHP_VERSION, '<' ) ) {
	add_action( 'admin_notices', 'bigbox_php_admin_notices' );

	if ( is_admin() ) {
		return;
	}

	wp_die( bigbox_get_php_notice_text() );
}

/**
 * Output a notice that the minimum PHP version is not met.
 *
 * @since 1.10.0
 */
function bigbox_php_admin_notices() {
	echo '<div class="notice notice-error"><p>' . bigbox_get_php_notice_text() . '</p></div>';
}

/**
 * PHP upgrade notice text.
 *
 * @since 1.10.0
 *
 * @return string
 */
function bigbox_get_php_notice_text() {
	/**
	 * Filter text shown when current PHP version does not meet requirements.
	 *
	 * @since 1.10.0
	 *
	 * @param string $text Text to display.
	 */
	return apply_filters(
		'bigbox_php_notice_text',
		/* translators: %s Minimum PHP version required for theme to run. */
		wp_kses_post( sprintf( __( 'BigBox requires PHP version <code>%s</code> or above to be active. Please contact your web host to upgrade.', 'bigbox' ), esc_attr( BIGBOX_PHP_VERSION ) ) )
	);
}

// Composer autoloader.
require_once __DIR__ . '/bootstrap/autoload.php';

// Custom template loader.
require_once __DIR__ . '/bootstrap/template-loader.php';

// Start things.
require_once __DIR__ . '/bootstrap/app.php';

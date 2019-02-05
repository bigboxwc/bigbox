<?php
/**
 * PHP compatibility check.
 *
 * @since 1.15.0
 *
 * @package BigBox
 * @category Bootstrap
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Minimum versions
define( 'BIGBOX_PHP_VERSION', '7.0.0' );
define( 'BIGBOX_WORDPRESS_VERSION', '5.0' );

// Do not allow the theme to be active if the PHP version is not met.
if ( version_compare( PHP_VERSION, BIGBOX_PHP_VERSION, '<' ) ) {
	add_action( 'admin_notices', 'bigbox_php_admin_notices' );

	if ( is_admin() ) {
		return;
	}

	wp_die( esc_html( bigbox_get_php_notice_text() ) ); // WPCS: XSS okay.
}

// Do not allow the theme to be active if the WordPress version is not met.
if ( version_compare( get_bloginfo( 'version' ), BIGBOX_WORDPRESS_VERSION, '<' ) ) {
	add_action( 'admin_notices', 'bigbox_wordpress_admin_notices' );

	if ( is_admin() ) {
		return;
	}

	wp_die( esc_html( bigbox_get_wordpress_notice_text() ) ); // WPCS: XSS okay.
}

/**
 * Output a notice that the minimum PHP version is not met.
 *
 * @since 1.10.0
 */
function bigbox_php_admin_notices() {
	echo '<div class="notice notice-error"><p>' . esc_html( bigbox_get_php_notice_text() ) . '</p></div>'; // WPCS: XSS okay.
}

/**
 * PHP upgrade notice text.
 *
 * @since 1.10.0
 *
 * @return string
 */
function bigbox_get_php_notice_text() {
	/* translators: %s Minimum PHP version required for theme to run. */
	$notice_text = sprintf( __( 'BigBox requires PHP version %s or above to be active. Please contact your web host to upgrade.', 'bigbox' ), esc_attr( BIGBOX_PHP_VERSION ) );

	/**
	 * Filter text shown when current PHP version does not meet requirements.
	 *
	 * @since 1.10.0
	 *
	 * @param string $text Text to display.
	 */
	return apply_filters( 'bigbox_php_notice_text', $notice_text );
}

/**
 * Output a notice that the minimum WordPress version is not met.
 *
 * @since 3.0.0
 */
function bigbox_wordpress_admin_notices() {
	echo '<div class="notice notice-error"><p>' . esc_html( bigbox_get_wordpress_notice_text() ) . '</p></div>'; // WPCS: XSS okay.
}

/**
 * WordPress upgrade notice text.
 *
 * @since 3.0.0
 *
 * @return string
 */
function bigbox_get_wordpress_notice_text() {
	/* translators: %s Minimum PHP version required for theme to run. */
	$notice_text = sprintf( __( 'BigBox requires WordPress version %s or above to be active. Please contact your web host to upgrade.', 'bigbox' ), esc_attr( BIGBOX_WORDPRESS_VERSION ) );

	/**
	 * Filter text shown when current WordPress version does not meet requirements.
	 *
	 * @since 3.0.0
	 *
	 * @param string $text Text to display.
	 */
	return apply_filters( 'bigbox_wordpress_notice_text', $notice_text );
}

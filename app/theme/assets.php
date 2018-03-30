<?php
/**
 * Load public assets.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue styles.
 *
 * @since 1.0.0
 */
function bigbox_enqueue_styles() {
	$version    = bigbox_get_theme_version();
	$stylesheet = bigbox_get_theme_name();

	$deps = [];

	wp_enqueue_style( $stylesheet, get_template_directory_uri() . '/public/css/app.min.css', $deps, $version );
	wp_add_inline_style( bigbox_get_theme_name(), bigbox_customize_css() );
}
add_action( 'wp_enqueue_scripts', 'bigbox_enqueue_styles' );

/**
 * Enqueue scripts.
 *
 * @since 1.0.0
 */
function bigbox_enqueue_scripts() {
	$version    = bigbox_get_theme_version();
	$stylesheet = bigbox_get_theme_name();

	$deps = [
		'wp-util',
		'wp-api',
	];

	// Combined application scripts.
	wp_enqueue_script( $stylesheet, get_template_directory_uri() . '/public/js/app.min.js', $deps, $version, true );

	// Send information to application scripts.
	wp_localize_script(
		$stylesheet, 'bigbox', apply_filters(
			'bigboxJsSettings', []
		)
	);
}
add_action( 'wp_enqueue_scripts', 'bigbox_enqueue_scripts' );

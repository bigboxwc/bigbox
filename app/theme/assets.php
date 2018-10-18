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

	// Load Google fonts if needed.
	$google = bigbox_get_google_fonts_url();

	if ( $google ) {
		wp_enqueue_style( $stylesheet . '-fonts', $google, [], $version );
	}

	// Base and dynamic styles.
	wp_enqueue_style( $stylesheet, get_template_directory_uri() . '/public/css/app.min.css', [], $version );
	wp_style_add_data( $stylesheet, 'rtl', 'replace' );

	/**
	 * Filter to toggle the output of CSS generated from the customizer in the page source.
	 *
	 * @since 1.0.0
	 *
	 * @param bool
	 */
	if ( apply_filters( 'bigbox_customize_css_inline', true ) ) {
		wp_add_inline_style( $stylesheet, bigbox_customize_inline_css() );
	}
}
add_action( 'wp_enqueue_scripts', 'bigbox_enqueue_styles', 20 );

/**
 * Editor styles
 *
 * @since 1.0.0
 */
function bigbox_editor_styles() {
	$google = bigbox_get_google_fonts_url();
	$styles = [ 'public/css/editor.min.css' ];

	if ( $google ) {
		$styles[] = $google;
	}

	add_editor_style( $styles );
}
add_action( 'after_setup_theme', 'bigbox_editor_styles' );

// @codingStandardsIgnoreStart
/**
 * Add type declarations to editor.
 *
 * @since 1.0.0
 */
function bigbox_editor_inline_styles( $mceInit ) {
	$mceInit['content_style'] = require_once get_template_directory() . '/app/customize/output/editor.php';

	return $mceInit;
}
// @codingStandardsIgnoreEnd
add_filter( 'tiny_mce_before_init', 'bigbox_editor_inline_styles' );

/**
 * Enqueue scripts.
 *
 * @since 1.0.0
 */
function bigbox_enqueue_scripts() {
	$version    = bigbox_get_theme_version();
	$stylesheet = bigbox_get_theme_name();

	$deps = [
		'hoverIntent',
	];

	// Combined application scripts.
	wp_enqueue_script( $stylesheet, get_template_directory_uri() . '/public/js/app.min.js', $deps, $version, true );

	// Send information to application scripts.
	$js_data = [
		'backgroundColor' => sanitize_hex_color( get_background_color() ),
	];

	wp_localize_script(
		$stylesheet,
		'bigbox',
		/**
		 * Filter the data sent to the main Javascript script.
		 *
		 * @since 1.0.0
		 *
		 * @param array $js JS object additions.
		 */
		apply_filters( 'bigbox_js', $js_data )
	);
}
add_action( 'wp_enqueue_scripts', 'bigbox_enqueue_scripts', 20 );

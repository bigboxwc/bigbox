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
	$deps       = [];

	// Load Google fonts if needed.
	$google = bigbox_get_google_fonts_url();

	if ( $google ) {
		wp_enqueue_style(
			$stylesheet . '-fonts',
			$google,
			[],
			$version
		);

		$deps[] = $stylesheet . '-fonts';
	}

	// Base and dynamic styles.
	wp_enqueue_style(
		$stylesheet,
		get_template_directory_uri() . '/public/css/app-css.min.css',
		$deps,
		$version
	);
	wp_style_add_data( $stylesheet, 'rtl', 'replace' );

	/**
	 * Filter to toggle the output of CSS generated from the customizer in the page source.
	 *
	 * @since 1.0.0
	 *
	 * @param bool
	 */
	$inline_css = apply_filters( 'bigbox_customize_css_inline', true );

	if ( $inline_css ) {
		wp_add_inline_style(
			$stylesheet,
			bigbox_customize_inline_css()
		);
	}
}
add_action( 'wp_enqueue_scripts', 'bigbox_enqueue_styles', 20 );

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
	wp_enqueue_script(
		$stylesheet,
		get_template_directory_uri() . '/public/js/app.min.js',
		$deps,
		$version,
		true
	);

	// Send information to application scripts.
	$js_data = [
		'backgroundColor' => sanitize_hex_color( maybe_hash_hex_color( get_background_color() ) ),
	];

	/**
	 * Filter the data sent to the main Javascript script.
	 *
	 * @since 1.0.0
	 *
	 * @param array $js JS object additions.
	 */
	$js_data = apply_filters( 'bigbox_js', $js_data );

	wp_localize_script(
		$stylesheet,
		'bigbox',
		$js_data
	);
}
add_action( 'wp_enqueue_scripts', 'bigbox_enqueue_scripts', 20 );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 *
 * @since 1.16.0
 */
function bigbox_skip_link_focus_fix() {
	echo '<script>';
	echo file_get_contents( get_template_directory() . '/public/js/skip-link-focus-fix.min.js' );
	echo '</script>';
}
add_action( 'wp_print_footer_scripts', 'bigbox_skip_link_focus_fix' );

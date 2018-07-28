<?php
/**
 * Preview changes made in the customizer.
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
 * Enqueue customizer scripts.
 *
 * @since 1.0.0
 */
function bigbox_customize_preview_init() {
	wp_enqueue_script(
		'webfontloader',
		'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js',
		[],
		'1.6.26',
		true
	);

	wp_enqueue_script(
		'bigbox-customize-preview',
		get_template_directory_uri() . '/public/js/customize-preview.min.js',
		[ 'customize-preview', 'underscore' ],
		bigbox_get_theme_version(),
		true
	);
}
add_action( 'customize_preview_init', 'bigbox_customize_preview_init', 99 );

/**
 * Return filtered inline CSS for live previews.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_preview_css() {
	$customized = json_decode( wp_unslash( $_POST['customized'] ), true ); // @codingStandardsIgnoreLine

	// Filter `get_theme_mod()` calls for customized settings.
	foreach ( $customized as $setting_id => $value ) {
		add_filter(
			'theme_mod_' . sanitize_key( $setting_id ), function( $value ) use ( $setting_id ) {
				if ( isset( $customized[ $setting_id ] ) ) {
					return $customized[ $setting_id ];
				}

				return $value;
			}
		);
	}

	return wp_send_json_success(
		[
			'css'        => bigbox_customize_inline_css(),
			'fontFamily' => bigbox_get_google_font_family_string(),
		]
	);
}
add_action( 'wp_ajax_bigbox-preview-css', 'bigbox_preview_css' );

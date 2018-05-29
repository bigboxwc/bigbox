<?php
/**
 * Customize(r) controls.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

// Load panels/sections/controls.
require_once get_template_directory() . '/app/customize/controls/header.php';
require_once get_template_directory() . '/app/customize/controls/wordpress.php';
require_once get_template_directory() . '/app/customize/controls/colors.php';
require_once get_template_directory() . '/app/customize/controls/type.php';

/**
 * Register scripts for controlling controls.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_controls_enqueue_scripts( $wp_customize ) {
	wp_enqueue_script(
		'bigbox-customize-controls',
		get_template_directory_uri() . '/public/js/customize-controls.min.js',
		[ 'customize-controls', 'underscore' ],
		bigbox_get_theme_version(),
		true
	);

	wp_localize_script(
		'bigbox-customize-controls', 'bigboxCustomizeControls', apply_filters(
			'bigbox_customize_controls_js', [
			'fonts' => json_decode( file_get_contents( get_template_directory() . '/resources/data/google-fonts.json' ) ), // @codingStandardsIgnoreLine
			]
		)
	);

	wp_enqueue_style(
		'bigbox-customize-controls',
		get_template_directory_uri() . '/public/css/customize-controls.min.css',
		[],
		bigbox_get_theme_version()
	);
}
add_action( 'customize_controls_enqueue_scripts', 'bigbox_customize_controls_enqueue_scripts' );

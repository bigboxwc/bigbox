<?php
/**
 * Core customize control tweaks.
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
 * Adds postMessage support for site title and adds a note about description not being output.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_register( $wp_customize ) {
	// postMessage some settings.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'header_text' )->transport     = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Update title of Tagline.
	// Translators: Customizer control label.
	$wp_customize->get_control( 'blogdescription' )->description = esc_html__( 'Not output but used for SEO', 'bigbox' );

	// Update label of Header Text
	// Translators: Customizer control label.
	$wp_customize->get_control( 'header_text' )->label = esc_html__( 'Display Site Title', 'bigbox' );

	// Move background color.
	$wp_customize->get_control( 'background_color' )->section = 'colors-elements';

	// Update branding partial when Site Title or text changes.
	foreach ( [ 'blogname', 'header_text' ] as $setting ) {
		$wp_customize->selective_refresh->add_partial(
			$setting, [
				'selector'            => '.site-title',
				'container_inclusive' => false,
				'render_callback'     => function() {
					bigbox_partial( 'branding' );
				},
			]
		);
	}
}
add_action( 'customize_register', 'bigbox_customize_register', 11 );

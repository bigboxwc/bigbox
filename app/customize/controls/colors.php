<?php
/**
 * Color customize controls.
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
 * Colors panels.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_register_colors_panels( $wp_customize ) {
	// Create panel.
	$wp_customize->add_panel(
		'colors', [
			// Translators: Customizer panel title.
			'title'    => esc_html__( 'Colors', 'bigbox' ),
			'priority' => 30,
		]
	);
}
add_action( 'customize_register', 'bigbox_customize_register_colors_panels' );

/**
 * Colors sections.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_register_colors_sections( $wp_customize ) {
	$wp_customize->add_section(
		'colors-scheme', [
			// Translators: Customizer section title.
			'title'    => esc_html__( 'Scheme', 'bigbox' ),
			'panel'    => 'colors',
			'priority' => 10,
		]
	);

	$wp_customize->add_section(
		'colors-grays', [
			// Translators: Customizer section title.
			'title'    => esc_html__( 'Grays', 'bigbox' ),
			'panel'    => 'colors',
			'priority' => 20,
		]
	);

	$wp_customize->add_section(
		'colors-elements', [
			// Translators: Customizer section title.
			'title'    => esc_html__( 'Elements', 'bigbox' ),
			'panel'    => 'colors',
			'priority' => 30,
		]
	);
}
add_action( 'customize_register', 'bigbox_customize_register_colors_sections' );

/**
 * Colors controls.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_register_colors_controls( $wp_customize ) {
	$controls = bigbox_get_theme_colors();

	foreach ( $controls as $section => $colors ) {

		foreach ( $colors as $theme_color => $color ) {
			$key = "color-${theme_color}";

			$wp_customize->add_setting(
				$key, [
					'default'           => $color['default'],
					'transport'         => 'postMessage',
					'sanitize_callback' => 'sanitize_hex_color',
				]
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$key,
					[
						'label'   => $color['label'],
						'section' => 'colors-' . $section,
					]
				)
			);
		}
	}
}
add_action( 'customize_register', 'bigbox_customize_register_colors_controls' );

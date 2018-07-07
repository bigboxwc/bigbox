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
		'colors-palette', [
			// Translators: Customizer section title.
			'title'    => esc_html__( 'Palette', 'bigbox' ),
			'panel'    => 'colors',
			'priority' => 10,
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
	$colors = bigbox_get_theme_colors();

	unset( $colors['black'] );
	unset( $colors['white'] );

	$wp_customize->register_control_type( 'BigBox\Customize\WP_Customize_Color_Control' );

	foreach ( $colors as $theme_color => $color ) {
		$key = "color-${theme_color}";

		$wp_customize->add_setting(
			$key, [
				'default'           => $color['color'],
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			]
		);

		$wp_customize->add_control(
			new BigBox\Customize\WP_Customize_Color_Control(
				$wp_customize,
				$key,
				[
					'label'    => esc_html( $color['name'] ),
					'section'  => 'colors-palette',
					'palettes' => bigbox_customize_controls_color_palettes(),
				]
			)
		);
	}

	// Add a link to suggest other control elements.
	$wp_customize->add_setting(
		'bigbox-colors-element-missing', [
			'sanitize_callback' => '__return_false',
		]
	);

	$wp_customize->add_control(
		new BigBox\Customize\WP_Customize_Content_Control(
			$wp_customize,
			'bigbox-colors-element-missing',
			[
				'label'    => esc_html__( '⚡ Want to see something else here?', 'bigbox' ),
				'content'  => '<p>' . esc_html__( 'Want specific control over an individual element\'s color?', 'bigbox' ) . '</p><p><a href="https://bigboxwc.com/account/support" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Contact us with a suggestion &rarr;', 'bigbox' ) . '</a></p>',
				'priority' => 9999,
				'section'  => 'colors-elements',
			]
		)
	);
}
add_action( 'customize_register', 'bigbox_customize_register_colors_controls', 20 );

/**
 * Get color palettes for custom controls.
 *
 * @since 1.9.0
 *
 * @return array
 */
function bigbox_customize_controls_color_palettes() {
	$palettes = [];
	$colors   = bigbox_get_theme_colors();

	foreach ( $colors as $theme_color => $color ) {
		$palettes[] = bigbox_get_theme_color( $theme_color );
	}

	$palettes = array_slice( $palettes, 0, 5 );

	$palettes[] = bigbox_get_theme_color( 'gray-200' );
	$palettes[] = bigbox_get_theme_color( 'gray-400' );
	$palettes[] = bigbox_get_theme_color( 'gray-700' );

	return $palettes;
}

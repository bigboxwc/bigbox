<?php
/**
 * Type customize controls.
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
 * Type sections.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_register_type_sections( $wp_customize ) {
	$wp_customize->add_section(
		'type', [
			'title'    => _x( 'Typography', 'customizer section title (type)', 'bigbox' ),
			'priority' => 20,
		]
	);
}
add_action( 'customize_register', 'bigbox_customize_register_type_sections' );

/**
 * Type controls.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_register_type_controls( $wp_customize ) {
	$wp_customize->add_setting(
		'type-font-family', [
			'default' => 'default',
		]
	);

	$wp_customize->add_control(
		'type-font-family', [
			'label'    => esc_html__( 'Font Family', 'bigbox' ),
			'type'     => 'select',
			'choices'  => [
				'default' => esc_html__( 'System Default', 'bigbox' ),
			],
			'section'  => 'type',
		]
	);

	$weights = [
		'base' => esc_html__( 'Base Font Weight', 'bigbox' ),
		'bold' => esc_html__( 'Bold Font Weight', 'bigbox' ),
	];

	foreach ( $weights as $weight => $label ) {
		$key = "type-{$weight}";

		$wp_customize->add_setting(
			$key, [
				'default' => 'normal',
			]
		);

		$wp_customize->add_control(
			$key, [
				'label'    => $label,
				'type'     => 'select',
				'choices'  => [
					'normal' => 400
				],
				'section'  => 'type',
			]
		);

	}
}
add_action( 'customize_register', 'bigbox_customize_register_type_controls' );

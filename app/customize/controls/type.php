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
			'default'   => 'default',
			'transport' => 'postMessage',
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

	$wp_customize->add_setting(
		'type-font-size', [
			'default'   => 1,
			'transport' => 'postMessage',
		]
	);

	$wp_customize->add_control(
		'type-font-size', [
			'label'    => esc_html__( 'Base Font Size', 'bigbox' ),
			'description' => wp_kses( __( 'Value is measured in <code>em</code>. 1em = 16px', 'bigbox' ), [ 'code' => [] ] ),
			'type'     => 'number',
			'input_atts' => [
				'min'  => 0,
				'max'  => 999,
				'step' => 0.01,
			],
			'section'  => 'type',
		]
	);

	$weights = [
		'base' => [
			'label'  => esc_html__( 'Base Font Weight', 'bigbox' ),
			'weight' => 400,
		],
		'bold' => [
			'label'  => esc_html__( 'Bold Font Weight', 'bigbox' ),
			'weight' => 500,
		]
	];

	foreach ( $weights as $weight => $data ) {
		$key = "type-font-weight-{$weight}";

		$wp_customize->add_setting(
			$key, [
				'default'   => 'normal',
				'transport' => 'postMessage',
			]
		);

		$wp_customize->add_control(
			$key, [
				'label'    => $data['label'],
				'type'     => 'select',
				'choices'  => [
					100 => 100,
					200 => 200,
					300 => 300,
					400 => 400,
					500 => 500,
					600 => 600,
					700 => 700,
					800 => 800,
				],
				'section'  => 'type',
			]
		);

	}
}
add_action( 'customize_register', 'bigbox_customize_register_type_controls' );

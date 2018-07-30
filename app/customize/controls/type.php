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
 * Add a list of Google Fonts to the JS settings.
 *
 * @since 1.5.0
 *
 * @param array $settings JS Settings.
 * @return array
 */
function bigbox_customize_controls_js_fonts( $settings ) {
	$settings['typography'] = [
		'fontList' => json_decode( file_get_contents( get_template_directory() . '/resources/data/google-fonts.json' ) ), // @codingStandardsIgnoreLine
	];

	return $settings;
}
add_filter( 'bigbox_customize_controls_js', 'bigbox_customize_controls_js_fonts' );

/**
 * Type sections.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_register_type_sections( $wp_customize ) {
	$wp_customize->add_section(
		'type',
		[
			/* translators: Customizer section title. */
			'title'    => __( 'Typography', 'bigbox' ),
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
		'type-font-family',
		[
			'default'           => 'Lato',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		]
	);

	$wp_customize->add_control(
		'type-font-family',
		[
			/* translators: Customizer control name. */
			'label'   => __( 'Font Family', 'bigbox' ),
			'type'    => 'select',
			'choices' => [
				/* translators: Customizer control value. */
				'default' => __( 'System Default', 'bigbox' ),
			],
			'section' => 'type',
		]
	);

	$wp_customize->add_setting(
		'type-font-family-fallback',
		[
			'default'           => 'sans-serif',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		]
	);

	$wp_customize->add_control(
		'type-font-family-fallback',
		[
			'active_callback' => '__return_false',
			'type'            => 'select',
			'choices'         => [
				/* translators: Customizer control value. */
				'serif'      => __( 'Serif', 'bigbox' ),
				/* translators: Customizer control value. */
				'sans-serif' => __( 'Sans Serif', 'bigbox' ),
				/* translators: Customizer control value. */
				'display'    => __( 'Display', 'bigbox' ),
				/* translators: Customizer control value. */
				'cursive'    => __( 'Handwriting', 'bigbox' ),
				/* translators: Customizer control value. */
				'monospace'  => __( 'Monospace', 'bigbox' ),
			],
			'section'         => 'type',
		]
	);

	$wp_customize->add_setting(
		'type-font-size',
		[
			'default'           => 1,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		]
	);

	$wp_customize->add_control(
		'type-font-size',
		[
			/* translators: Customizer control label. */
			'label'       => __( 'Base Font Size', 'bigbox' ),
			/* translators: Customizer control description. */
			'description' => wp_kses( __( 'Value is measured in <code>em</code>. 1em = 16px', 'bigbox' ), [ 'code' => [] ] ),
			'type'        => 'number',
			'input_atts'  => [
				'min'  => 0,
				'max'  => 999,
				'step' => 0.01,
			],
			'section'     => 'type',
		]
	);

	$weights = [
		'base' => [
			/* translators: Customizer control label. */
			'label'       => __( 'Base Font Weight', 'bigbox' ),
			'description' => '',
			'weight'      => 'regular',
		],
		'bold' => [
			/* translators: Customizer control label. */
			'label'       => __( 'Bold Font Weight', 'bigbox' ),
			'description' => __( 'If no alternate weight is offered it will be faux-bolded by the web browser.', 'bigbox' ),
			'weight'      => 700,
		],
	];

	foreach ( $weights as $weight => $data ) {
		$key = "type-font-weight-{$weight}";

		$wp_customize->add_setting(
			$key,
			[
				'default'           => $data['weight'],
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			]
		);

		$wp_customize->add_control(
			$key,
			[
				'label'       => $data['label'],
				'description' => $data['description'],
				'type'        => 'select',
				'choices'     => [
					100 => 100,
					200 => 200,
					300 => 300,
					400 => 400,
					500 => 500,
					600 => 600,
					700 => 700,
					800 => 800,
				],
				'section'     => 'type',
			]
		);
	}
}
add_action( 'customize_register', 'bigbox_customize_register_type_controls' );

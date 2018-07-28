<?php
/**
 * Store notice controls.
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
 * Store notice control.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_woocommerce_customize_register_store_notice_controls( $wp_customize ) {
	// Position.
	$wp_customize->add_setting(
		'demo-store-notice-position',
		[
			'default'           => 'bottom',
			'sanitize_callback' => 'sanitize_text_field',
		]
	);

	$wp_customize->add_control(
		'demo-store-notice-position',
		[
			/* translators: Customizer control label. */
			'label'    => __( 'Position', 'bigbox' ),
			'type'     => 'select',
			'choices'  => [
				/* translators: Customizer control value. */
				'top'    => __( 'Top', 'bigbox' ),
				/* translators: Customizer control value. */
				'bottom' => __( 'Bottom', 'bigbox' ),
			],
			'section'  => 'woocommerce_store_notice',
			'priority' => 20,
		]
	);

	// Colors.
	$wp_customize->add_setting(
		'demo-store-notice-color',
		[
			'default'           => '#565656',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	$wp_customize->add_control(
		new BigBox\Customize\WP_Customize_Color_Control(
			$wp_customize,
			'demo-store-notice-color',
			[
				/* translators: Customizer control label. */
				'label'    => __( 'Text Color', 'bigbox' ),
				'section'  => 'woocommerce_store_notice',
				'priority' => 30,
				'palettes' => bigbox_customize_controls_color_palettes(),
			]
		)
	);

	$wp_customize->add_setting(
		'demo-store-notice-color-background',
		[
			'default'           => '#e8bc55',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	$wp_customize->add_control(
		new BigBox\Customize\WP_Customize_Color_Control(
			$wp_customize,
			'demo-store-notice-color-background',
			[
				/* translators: Customizer control label. */
				'label'    => __( 'Background Color', 'bigbox' ),
				'section'  => 'woocommerce_store_notice',
				'priority' => 40,
				'palettes' => bigbox_customize_controls_color_palettes(),
			]
		)
	);
}
add_action( 'customize_register', 'bigbox_woocommerce_customize_register_store_notice_controls' );

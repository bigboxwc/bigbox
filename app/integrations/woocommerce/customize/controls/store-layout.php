<?php
/**
 * Store layout (section) and controls.
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
 * Layout sections.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_woocommerce_customize_register_layout_sections( $wp_customize ) {
	$wp_customize->add_section(
		'woocommerce-bigbox-layout', [
			// Translators: Customizer section title.
			'title'    => esc_html__( 'Layout', 'bigbox' ),
			'priority' => 50,
			'panel'    => 'woocommerce',
		]
	);
}
add_action( 'customize_register', 'bigbox_woocommerce_customize_register_layout_sections' );

/**
 * Layout controls.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_woocommerce_customize_register_layout_controls( $wp_customize ) {
	// Toggle default shop sidebar.
	$wp_customize->add_setting(
		'hide-shop-sidebar', array(
			'default'           => false,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'hide-shop-sidebar', [
			// Translators: Customizer control label.
			'label'    => esc_html__( 'Hide shop sidebar', 'bigbox' ),
			'type'     => 'checkbox',
			'section'  => 'woocommerce-bigbox-layout',
			'priority' => 10,
		]
	);
}
add_action( 'customize_register', 'bigbox_woocommerce_customize_register_layout_controls' );

<?php
/**
 * Inventory controls.
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
 * Catalog controls.
 *
 * @since 3.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_woocommerce_customize_register_catalog_controls( $wp_customize ) {
	$wp_customize->add_setting(
		'display-inventory',
		[
			'default'           => false,
			'sanitize_callback' => 'absint',
		]
	);

	$wp_customize->add_control(
		'display-inventory',
		[
			/* translators: Customizer control label. */
			'label'    => __( 'Display stock information', 'bigbox' ),
			'type'     => 'checkbox',
			'section'  => 'woocommerce_product_catalog',
			'priority' => 50,
		]
	);

	$wp_customize->add_setting(
		'display-sale-flash',
		[
			'default'           => false,
			'sanitize_callback' => 'absint',
		]
	);

	$wp_customize->add_control(
		'display-sale-flash',
		[
			/* translators: Customizer control label. */
			'label'    => __( 'Display sale "flash"', 'bigbox' ),
			'type'     => 'checkbox',
			'section'  => 'woocommerce_product_catalog',
			'priority' => 60,
		]
	);

	$wp_customize->add_setting(
		'display-short-description',
		[
			'default'           => false,
			'sanitize_callback' => 'absint',
		]
	);

	$wp_customize->add_control(
		'display-short-description',
		[
			/* translators: Customizer control label. */
			'label'    => __( 'Display short description', 'bigbox' ),
			'type'     => 'checkbox',
			'section'  => 'woocommerce_product_catalog',
			'priority' => 60,
		]
	);

	$wp_customize->add_setting(
		'display-more-options',
		[
			'default'           => true,
			'sanitize_callback' => 'absint',
		]
	);

	$wp_customize->add_control(
		'display-more-options',
		[
			/* translators: Customizer control label. */
			'label'    => __( 'Display "More Options" link for variable products', 'bigbox' ),
			'type'     => 'checkbox',
			'section'  => 'woocommerce_product_catalog',
			'priority' => 70,
		]
	);
}
add_action( 'customize_register', 'bigbox_woocommerce_customize_register_catalog_controls', 99 );

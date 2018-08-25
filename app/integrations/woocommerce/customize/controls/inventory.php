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
 * Inventory control.
 *
 * @since 1.14.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_woocommerce_customize_register_inventory_controls( $wp_customize ) {
	$wp_customize->add_setting(
		'display-inventory',
		[
			'default'           => true,
			'sanitize_callback' => 'absint',
		]
	);

	$wp_customize->add_control(
		'display-inventory',
		[
			/* translators: Customizer control label. */
			'label'    => __( 'Display stock counts', 'bigbox' ),
			'type'     => 'checkbox',
			'section'  => 'woocommerce_product_catalog',
			'priority' => 50,
		]
	);
}
add_action( 'customize_register', 'bigbox_woocommerce_customize_register_inventory_controls' );

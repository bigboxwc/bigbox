<?php
/**
 * Navbar customize controls.
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
 * Navbar controls.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_woocommerce_customize_register_navbar_controls( $wp_customize ) {
	// Choose which taxonomy appears in the dropdown.
	$wp_customize->add_setting(
		'navbar-dropdown-source', [
			'default'   => 'product_cat',
			'transport' => 'postMessage',
		]
	);

	$wp_customize->add_control(
		'navbar-dropdown-source', [
			'label'    => esc_html__( 'Dropdown Source', 'bigbox' ),
			'type'     => 'select',
			'choices'  => bigbox_woocommerce_customize_get_dropdown_taxonomies(),
			'section'  => 'navbar',
		]
	);
}
add_action( 'customize_register', 'bigbox_woocommerce_customize_register_navbar_controls' );

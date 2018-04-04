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
 * Return a list of taxonomies available for the dropdown.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_woocommerce_customize_get_dropdown_taxonomies() {
	$taxonomies = get_object_taxonomies( 'product', 'objects' );
	$choices    = [];

	foreach ( $taxonomies as $taxonomy ) {
		if ( ! $taxonomy->public ) {
			continue;
		}

		$choices[ $taxonomy->name ] = esc_html( $taxonomy->label );
	}

	// This is public but let's remove it.
	if ( isset( $choices[ 'product_shipping_class' ] ) ) {
		unset( $choices[ 'product_shipping_class' ] );
	}

	return $choices;
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

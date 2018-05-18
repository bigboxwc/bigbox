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
	if ( isset( $choices['product_shipping_class'] ) ) {
		unset( $choices['product_shipping_class'] );
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
		'navbar-source-dropdown', [
			'default'           => 'product_cat',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		]
	);

	$wp_customize->add_control(
		'navbar-source-dropdown', [
			// Translators: Customizer control label.
			'label'           => esc_html__( 'Dropdown Source', 'bigbox' ),
			'type'            => 'select',
			'choices'         => bigbox_woocommerce_customize_get_dropdown_taxonomies(),
			'section'         => 'navbar',
			'priority'        => 20,
			'active_callback' => function() {
				return ! bigbox_is_integration_active( 'facetwp' );
			},
		]
	);

	// Toggle account menu item.
	$wp_customize->add_setting(
		'nav-item-account', [
			'default'           => true,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_attr',
		]
	);

	$wp_customize->add_control(
		'nav-item-account', [
			// Translators: Customizer control label.
			'label'    => esc_html__( 'Display account menu item', 'bigbox' ),
			'type'     => 'checkbox',
			'section'  => 'navbar',
			'priority' => 10,
		]
	);

	// Toggle cart menu item.
	$wp_customize->add_setting(
		'nav-item-cart', array(
			'default'           => true,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'nav-item-cart', [
			// Translators: Customizer control label.
			'label'    => esc_html__( 'Display cart menu item', 'bigbox' ),
			'type'     => 'checkbox',
			'section'  => 'navbar',
			'priority' => 10,
		]
	);

	// Partial refreshes.
	$wp_customize->selective_refresh->add_partial(
		'navbar-source-dropdown', [
			'selector'            => '.navbar-search',
			'container_inclusive' => true,
			'render_callback'     => function() {
				bigbox_partial( 'navbar-search' );
			},
		]
	);

	$wp_customize->selective_refresh->add_partial(
		'navbar', [
			'selector'            => '.navbar-menu--account',
			'settings'            => [
				'nav-item-account',
				'nav-item-cart',
			],
			'container_inclusive' => true,
			'render_callback'     => function() {
				bigbox_partial( 'navbar-menu-account' );
			},
		]
	);
}
add_action( 'customize_register', 'bigbox_woocommerce_customize_register_navbar_controls' );

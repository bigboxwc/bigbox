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
 * Navbar sections.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_woocommerce_customize_register_navbar_sections( $wp_customize ) {
	$wp_customize->add_section(
		'nav-menus', array(
			'title'    => esc_html_x( 'Settings', 'customizer section title', 'bigbox' ),
			'panel'    => 'nav_menus',
			'priority' => 90,
		)
	);
}
add_action( 'customize_register', 'bigbox_woocommerce_customize_register_navbar_sections' );

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

	$wp_customize->add_setting(
		'nav-item-account', array(
			'default'   => true,
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'nav-item-account', array(
			'label'    => esc_html__( 'Display account menu item', 'listify' ),
			'type'     => 'checkbox',
			'priority' => 10,
			'section'  => 'nav-menus',
		)
	);

	$wp_customize->add_setting(
		'nav-item-cart', array(
			'default'   => true,
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'nav-item-cart', array(
			'label'    => esc_html__( 'Display cart menu item', 'listify' ),
			'type'     => 'checkbox',
			'priority' => 20,
			'section'  => 'nav-menus',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'navbar-dropdown-source', [
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

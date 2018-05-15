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
 * Return a list of dropdown facets.
 *
 * @since 1.0.0
 *
 * @param array $whitelist Facet types that can be used.
 * @return array
 */
function bigbox_facetwp_customize_get_sources( $whitelist = [] ) {
	$facets  = FWP()->helper->get_facets();
	$choices = [];

	foreach ( $facets as $facet ) {
		if ( ! in_array( $facet['type'], $whitelist, true ) ) {
			continue;
		}

		$choices[ $facet['name'] ] = $facet['label'];
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
function bigbox_facetwp_customize_register_navbar_controls( $wp_customize ) {
	$wp_customize->add_setting(
		'navbar-search-source', [
			'default'           => 'keyword',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		]
	);

	$wp_customize->selective_refresh->add_partial(
		'navbar-search-source', [
			'selector'            => '.navbar-search',
			'container_inclusive' => true,
			'render_callback'     => function() {
				bigbox_partial( 'navbar-search' );
			},
		]
	);

	$wp_customize->add_setting(
		'navbar-dropdown-source', [
			'default'           => 'category',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		]
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

	$wp_customize->add_control(
		'navbar-dropdown-source', [
			// Translators: Customizer control label.
			'label'       => esc_html__( 'Dropdown Facet', 'bigbox' ),
			// Translators: Customizer control description.
			'description' => esc_html__( 'Choose from one of your Dropdown facets. This facet cannot appear on the Shop page twice.', 'bigbox' ),
			'type'        => 'select',
			'choices'     => bigbox_facetwp_customize_get_sources( [ 'dropdown' ] ),
			'section'     => 'navbar',
			'priority'    => 20,
		]
	);

	$wp_customize->add_control(
		'navbar-search-source', [
			// Translators: Customizer control label.
			'label'       => esc_html__( 'Keyword Facet', 'bigbox' ),
			// Translators: Customizer control description.
			'description' => esc_html__( 'Choose from one of your Search facets. This facet cannot appear on the Shop page twice.', 'bigbox' ),
			'type'        => 'select',
			'choices'     => bigbox_facetwp_customize_get_sources( [ 'search' ] ),
			'section'     => 'navbar',
			'priority'    => 20,
		]
	);
}
add_action( 'customize_register', 'bigbox_facetwp_customize_register_navbar_controls' );

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
 * @return array
 */
function bigbox_facetwp_customize_get_dropdown_sources() {
	$facets  = FWP()->helper->get_facets();
	$choices = [];

	foreach ( $facets as $facet ) {
		if ( 'dropdown' !== $facet['type'] ) {
			continue;
		}

		$choices[ $facet['name'] ] = $facet['label'];
	}

	return $choices;
}

/**
 * Return a list of search or autocomplete facets.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_facetwp_customize_get_search_sources() {
	$facets  = FWP()->helper->get_facets();
	$choices = [];

	foreach ( $facets as $facet ) {
		if ( ! in_array( $facet['type'], [ 'search', 'autocomplete' ] ) ) {
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
	foreach ( [ 'navbar-dropdown-source', 'navbar-search-source' ] as $setting ) {
		// Choose which facet is used for the search.
		$wp_customize->add_setting(
			$setting, [
				'default'   => null,
				'transport' => 'postMessage',
			]
		);

		$wp_customize->selective_refresh->add_partial(
			$setting, [
				'selector'            => '.navbar',
				'container_inclusive' => false,
				'render_callback'     => function() {
					bigbox_partial( 'navbar' );
				},
			]
		);
	}

	$wp_customize->add_control(
		'navbar-dropdown-source', [
			'label'    => esc_html__( 'Dropdown Source', 'bigbox' ),
			'type'     => 'select',
			'choices'  => bigbox_facetwp_customize_get_dropdown_sources(),
			'section'  => 'navbar',
		]
	);

	$wp_customize->add_control(
		'navbar-search-source', [
			'label'    => esc_html__( 'Search Source', 'bigbox' ),
			'type'     => 'select',
			'choices'  => bigbox_facetwp_customize_get_search_sources(),
			'section'  => 'navbar',
		]
	);
}
add_action( 'customize_register', 'bigbox_facetwp_customize_register_navbar_controls' );

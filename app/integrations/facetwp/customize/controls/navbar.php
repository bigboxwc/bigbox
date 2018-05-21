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
	$choices = [
		// Translators: Customize control label.
		0 => esc_html__( '-- None --', 'bigbox' ),
	];

	foreach ( $facets as $facet ) {
		if ( ! in_array( $facet['type'], $whitelist, true ) ) {
			continue;
		}

		$choices[ $facet['name'] ] = $facet['label'];
	}

	return $choices;
}

/**
 * Navbar customize controls.
 *
 * Build more dynamic controls to avoid repeat.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 * @param string               $suffix  Suffix to create unique setting names.
 * @param array                $setting Extra setting arguments.
 * @param array                $control Extra control arguments.
 */
function bigbox_facetwp_customize_register_navbar_controls_group( $wp_customize, $suffix = false, $setting = [], $control = [] ) {
	$wp_customize->add_setting(
		'navbar-source-search' . $suffix, wp_parse_args(
			[
				'default'           => 'keyword',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
			], $setting
		)
	);

	$wp_customize->add_setting(
		'navbar-source-dropdown' . $suffix, [
			'default'           => 'categories',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		]
	);

	$wp_customize->selective_refresh->add_partial(
		'navbar-source-search' . $suffix, [
			'selector'            => '.navbar-search',
			'container_inclusive' => true,
			'render_callback'     => function() {
				bigbox_partial( 'navbar-search' );
			},
		]
	);

	$wp_customize->selective_refresh->add_partial(
		'navbar-source-dropdown' . $suffix, [
			'selector'            => '.navbar-search',
			'container_inclusive' => true,
			'render_callback'     => function() {
				bigbox_partial( 'navbar-search' );
			},
		]
	);

	$wp_customize->add_control(
		'navbar-source-dropdown' . $suffix, wp_parse_args(
			[
				// Translators: Customizer control label.
				'label'       => esc_html__( 'Dropdown Facet', 'bigbox' ),
				// Translators: Customizer control description.
				'description' => esc_html__( 'Choose from one of your Dropdown facets. This facet cannot appear on the Shop page twice.', 'bigbox' ),
				'type'        => 'select',
				'choices'     => bigbox_facetwp_customize_get_sources( [ 'dropdown' ] ),
				'section'     => 'navbar',
				'priority'    => 20,
			], $control
		)
	);

	$wp_customize->add_control(
		'navbar-source-search' . $suffix, wp_parse_args(
			[
				// Translators: Customizer control label.
				'label'       => esc_html__( 'Keyword Facet', 'bigbox' ),
				// Translators: Customizer control description.
				'description' => esc_html__( 'Choose from one of your Search facets. This facet cannot appear on the Shop page twice.', 'bigbox' ),
				'type'        => 'select',
				'choices'     => bigbox_facetwp_customize_get_sources( [ 'search' ] ),
				'section'     => 'navbar',
				'priority'    => 20,
			], $control
		)
	);
}

/**
 * Navbar controls.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_facetwp_customize_register_navbar_controls( $wp_customize ) {
	// Explain the dynamic nature.
	$wp_customize->add_setting(
		'bigbox-navbar-sources-dynamic', [
			'sanitize_callback' => '__return_false',
		]
	);

	$wp_customize->add_control(
		new BigBox\Customize\WP_Customize_Content_Control(
			$wp_customize,
			'bigbox-navbar-sources-dynamic',
			[
				'label'           => esc_html__( '⚡ These filters are dynamic', 'bigbox' ),
				'content'         => '<p>' . esc_html__( 'Adjusting these settings will only affect the current page. Navigate to a page not assigned to "Shop" to adjust the global filters.', 'bigbox' ) . '</p><p>' . '<a href="" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Learn more about dynamic shop pages &rarr;', 'bigbox' ) . '</a></p>',
				'priority'        => 15,
				'section'         => 'navbar',
				'active_callback' => function() {
					return is_page_template( bigbox_woocommerce_dynamic_shop_page_template() );
				},
			]
		)
	);

	// Global controls.
	bigbox_facetwp_customize_register_navbar_controls_group(
		$wp_customize, false, [], [
			'active_callback' => function() {
				return ! is_page_template( bigbox_woocommerce_dynamic_shop_page_template() );
			},
		]
	);

	// Dynamic shop pages.
	$pages = bigbox_woocommerce_get_dynamic_shop_pages();

	if ( empty( $pages ) ) {
		return;
	}

	foreach ( $pages as $page ) {
		bigbox_facetwp_customize_register_navbar_controls_group(
			$wp_customize, ( '-page-' . $page ), [], [
				'active_callback' => function() use ( $page ) {
					return is_page( $page ) && is_page_template( bigbox_woocommerce_dynamic_shop_page_template() );
				},
			]
		);
	}
}
add_action( 'customize_register', 'bigbox_facetwp_customize_register_navbar_controls' );

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
 * Navbar sections.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function bigbox_customize_register_navbar_sections( $wp_customize ) {
	$wp_customize->add_section(
		'navbar', [
			'title'    => _x( 'Header Search', 'customizer section title (header search)', 'bigbox' ),
			'priority' => 30,
		]
	);
}
add_action( 'customize_register', 'bigbox_customize_register_navbar_sections' );

<?php
/**
 * WordPress navigation menus.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Menu
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register navigation menu areas.
 *
 * @since 1.0.0
 */
function bigbox_register_nav_menus() {
	$navs = [
		'primary'   => esc_html__( 'Primary', 'bigbox' ),
		'secondary' => esc_html__( 'Secondary', 'bigbox' ),
	];

	$navs = apply_filters( 'bigbox_register_nav_menus', $navs );

	register_nav_menus( $navs );
}
add_action( 'after_setup_theme', 'bigbox_register_nav_menus' );

/**
 * Get primmary nav menus.
 *
 * @since 1.0.0
 *
 * @param array $args Menu arguments.
 * @return string
 */
function bigbox_get_primary_nav_menus( $args = [] ) {
	$menus = wp_cache_get( 'bigbox_get_primary_nav_menus', 'bigbox' );

	if ( false === $menus ) {
		ob_start();

		wp_nav_menu(
			[
				'theme_location' => 'primary',
				'menu_class'     => 'navbar-menu__items',
				'container'      => false,
				'fallback_cb'    => false,
			]
		);

		wp_nav_menu(
			[
				'theme_location' => 'secondary',
				'menu_class'     => 'navbar-menu__items',
				'container'      => false,
				'fallback_cb'    => false,
			]
		);

		$menus = ob_get_clean();

		wp_cache_set( 'bigbox_get_primary_nav_menus', $menus, 'bigbox' );
	}

	return $menus;
}

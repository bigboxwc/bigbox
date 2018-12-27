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
		/* translators: Navigation menu name. */
		'primary'   => __( 'Primary', 'bigbox' ),
		/* translators: Navigation menu name. */
		'secondary' => __( 'Secondary', 'bigbox' ),
	];

	/**
	 * Filter registered nav menus to be passed to `register_nav_menus()`.
	 *
	 * @since 1.0.0
	 *
	 * @param array $navs Nav menus to register.
	 */
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
		wp_enqueue_script( 'hoverIntent' );

		ob_start();

		wp_nav_menu(
			[
				'theme_location' => 'primary',
				'menu_class'     => 'navbar-menu__items navbar-menu__items-primary',
				'container'      => false,
				'fallback_cb'    => false,
			]
		);

		wp_nav_menu(
			[
				'theme_location' => 'secondary',
				'menu_class'     => 'navbar-menu__items navbar-menu__items-secondary',
				'container'      => false,
				'fallback_cb'    => false,
			]
		);

		$menus = ob_get_clean();

		wp_cache_set( 'bigbox_get_primary_nav_menus', $menus, 'bigbox' );
	}

	return $menus;
}

/**
 * Create a nav menu item to be displayed on mobile to navigate from submenu back to the parent.
 *
 * This duplicates each parent nav menu item and makes it the first child of itself.
 *
 * @param array  $sorted_menu_items Sorted nav menu items.
 * @param object $args              Nav menu args.
 * @return array Amended nav menu items.
 */
function bigbox_add_mobile_parent_nav_menu_items( $sorted_menu_items, $args ) {
	static $pseudo_id = 0;

	if ( ! isset( $args->theme_location ) || ! in_array( $args->theme_location, [ 'primary', 'secondary' ], true ) ) {
		return $sorted_menu_items;
	}

	$amended_menu_items = [];

	foreach ( $sorted_menu_items as $nav_menu_item ) {
		$amended_menu_items[] = $nav_menu_item;

		if ( in_array( 'menu-item-has-children', $nav_menu_item->classes, true ) ) {
			$parent_menu_item                   = clone $nav_menu_item;
			$parent_menu_item->original_id      = $nav_menu_item->ID;
			$parent_menu_item->ID               = --$pseudo_id;
			$parent_menu_item->db_id            = $parent_menu_item->ID;
			$parent_menu_item->object_id        = $parent_menu_item->ID;
			$parent_menu_item->classes          = [ 'menu-item-is-back' ];
			$parent_menu_item->menu_item_parent = $nav_menu_item->ID;
			$parent_menu_item->title            = _x( 'Back', 'mobile menu toggle', 'bigbox' );

			$amended_menu_items[] = $parent_menu_item;
		}
	}

	return $amended_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'bigbox_add_mobile_parent_nav_menu_items', 10, 2 );

/**
 * WCAG 2.0 Attributes for Dropdown Menus
 *
 * Adjustments to menu attributes to support WCAG 2.0 recommendations
 * for flyout and dropdown menus.
 *
 * @ref https://www.w3.org/WAI/tutorials/menus/flyout/
 *
 * @since 1.0.0
 *
 * @param array  $atts Menu item attributes.
 * @param object $item Menu item.
 * @return array
 */
function bigbox_nav_menu_link_attributes( $atts, $item ) {
	// Add [aria-haspopup] and [aria-expanded] to menu items that have children.
	$item_has_children = in_array( 'menu-item-has-children', $item->classes );

	if ( $item_has_children ) {
		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'bigbox_nav_menu_link_attributes', 10, 2 );

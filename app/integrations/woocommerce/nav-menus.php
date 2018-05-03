<?php
/**
 * WooCommerce navigation menus.
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
function bigbox_woocommerce_register_nav_menus() {
	$shop_page_display = get_option( 'woocommerce_shop_page_display', null );

	if ( ! in_array( $shop_page_display, [ 'both', 'subcategories' ], true ) ) {
		return;
	}

	$navs = [
		// Translators: Navigation menu name.
		'product-category-list' => esc_html__( 'Product Category List', 'bigbox' ),
	];

	register_nav_menus( $navs );
}
add_action( 'after_setup_theme', 'bigbox_woocommerce_register_nav_menus' );

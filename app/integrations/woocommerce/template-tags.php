<?php
/**
 * WooCommerce template tags.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Return Woocommerce view path.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_woocommerce_template_path() {
	return 'resources/views/integrations/woocommerce/';
}

/**
 * Determine if we are on a shop page.
 *
 * By default this checks for:
 *
 * - WooCommerce shop page.
 * - Dynamic shop page template.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function bigbox_is_shop() {
	$is_shop = (
		( is_shop() || is_product_taxonomy() )
		|| is_page_template( bigbox_woocommerce_dynamic_shop_page_template() )
	);

	/**
	 * Filters a conditional to determine if the current page is a shop.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $is_shop If the current page should be considered a shop.
	 */
	return apply_filters( 'bigbox_is_shop', $is_shop );
}

/**
 * Determine if a WooCommerce thumbnail should display.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product WooCommerce product. Attempts to find global if null.
 * @return mixed String of HTML for an image or null.
 */
function bigbox_woocommerce_has_product_image( $product = null ) {
	if ( ! $product ) {
		$product = wc_get_product( get_the_ID() );
	}

	if ( ! get_theme_mod( 'display-image-placeholders', true ) ) {
		return '' !== $product->get_image_id();
	}

	return '' !== $product->get_image();
}


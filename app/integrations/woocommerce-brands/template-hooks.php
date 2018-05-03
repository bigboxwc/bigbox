<?php
/**
 * WooCommerce Brands template hooks.
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

// @codingStandardsIgnoreStart
global $WC_Brands;

remove_action( 'woocommerce_product_meta_end', [ $WC_Brands, 'show_brand' ] );
add_action( 'woocommerce_product_additional_information', [ $WC_Brands, 'show_brand' ], 99 );
// @codingStandardsIgnoreEnd

// Add brand logo to single products.
add_action( 'woocommerce_single_product_summary', 'bigbox_woocommerce_single_brand_thumbnail', 1 );

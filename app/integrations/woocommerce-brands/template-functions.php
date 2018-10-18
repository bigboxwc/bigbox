<?php
/**
 * WooCommerce Brands template functions.
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
 * Output brand thumbnail.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_single_brand_thumbnail() {
	// @codingStandardsIgnoreStart
	global $WC_Brands;

	echo '<div class="woocommerce-product-brand">';

	echo $WC_Brands->output_product_brand(
		/**
		 * Filters the arguments used to output a brand logo.
		 *
		 * @since 1.0.0
		 *
		 * @param array $atts Attributes used to output the brand logo.
		 */
		apply_filters(
			'bigbox_woocommerce_product_brand_atts', [
				'post_id' => wc_get_product()->get_id(),
				'height'  => '50px',
			]
		)
	);

	echo '</div>';
	// @codingStandardsIgnoreEnd
}

/**
 * Enqueue styles.
 *
 * @since 1.16.0
 */
function bigbox_woocommerce_brands_enqueue_styles() {
	$version    = bigbox_get_theme_version();
	$parent     = bigbox_get_theme_name();
	$stylesheet = $parent . '-woocommerce-brands';

	wp_enqueue_style( $stylesheet, get_template_directory_uri() . '/public/css/woocommerce-brands.min.css', [ $parent ], $version );
	wp_style_add_data( $stylesheet, 'rtl', 'replace' );
}

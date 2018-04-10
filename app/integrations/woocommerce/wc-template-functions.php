<?php
/**
 * Override core WooCommerce template functions.
 *
 * These should be avoided and are only used when the necessary filter is not in place.
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
 * Display product sub categories as thumbnails.
 *
 * This is a replacement for woocommerce_product_subcategories which also does some logic
 * based on the loop. This function however just outputs when called.
 *
 * @since 3.3.1
 * @param array $args Arguments.
 * @return boolean
 */
function woocommerce_output_product_categories( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'before'    => apply_filters( 'woocommerce_before_output_product_categories', '' ),
		'after'     => apply_filters( 'woocommerce_after_output_product_categories', '' ),
		'parent_id' => 0,
	) );

	$product_categories = woocommerce_get_product_subcategories( $args['parent_id'] );
	$total              = count( $product_categories );

	if ( $total > 5 ) {
		$product_categories = array_slice( $product_categories, 0, 5 );
	}

	if ( ! $product_categories ) {
		return false;
	}

	echo $args['before']; // WPCS: XSS ok.

	foreach ( $product_categories as $category ) {
		wc_get_template( 'content-product_cat.php', array(
			'category' => $category,
		) );
	}

	echo $args['after']; // WPCS: XSS ok.

	return true;
}

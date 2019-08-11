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
 * Show subcategory thumbnails.
 *
 * @since 1.0.0
 *
 * @param mixed $category Category.
 */
function woocommerce_subcategory_thumbnail( $category ) {
	// Begin modification.
	$image        = false;
	$image_srcset = false;
	$image_sizes  = false;
	// End modification.
	$small_thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'woocommerce_thumbnail' );
	$dimensions           = wc_get_image_size( $small_thumbnail_size );
	$thumbnail_id         = get_term_meta( $category->term_id, 'thumbnail_id', true );

	if ( $thumbnail_id ) {
		$image        = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
		$image        = $image[0];
		$image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, $small_thumbnail_size ) : false;
		$image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, $small_thumbnail_size ) : false;
	}

	if ( $image ) {
		// Prevent esc_url from breaking spaces in urls for image embeds.
		// Ref: https://core.trac.wordpress.org/ticket/23605.
		$image = str_replace( ' ', '%20', $image );

		// Add responsive image markup if available.
		if ( $image_srcset && $image_sizes ) {
			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" />';
		} else {
			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
		}
	}
}

/**
 * Display product sub categories as thumbnails.
 *
 * @since 1.0.0
 *
 * @param array $args Arguments.
 * @return boolean
 */
function woocommerce_output_product_categories( $args = [] ) {
	$args = wp_parse_args(
		$args,
		[
			'before'    => apply_filters( 'woocommerce_before_output_product_categories', '' ),
			'after'     => apply_filters( 'woocommerce_after_output_product_categories', '' ),
			'parent_id' => 0,
		]
	);

	$product_categories = woocommerce_get_product_subcategories( $args['parent_id'] );
	$total              = count( $product_categories );

	// Begin modification.
	if ( $total > 5 ) {
		$product_categories = array_slice( $product_categories, 0, 5 );
	}

	// End modification.
	if ( ! $product_categories ) {
		return false;
	}

	echo $args['before']; // WPCS: XSS ok.

	foreach ( $product_categories as $category ) {
		wc_get_template(
			'content-product_cat.php',
			[
				'category' => $category,
			]
		);
	}

	echo $args['after']; // WPCS: XSS ok.

	return true;
}

<?php
/**
 * Config for light color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$light  = bigbox_get_theme_color( 'light' );
$rgba10 = bigbox_hex_to_rgba( $light, 0.10 );
$rgba30 = bigbox_hex_to_rgba( $light, 0.30 );
$rgba50 = bigbox_hex_to_rgba( $light, 0.50 );

return [
	// Solid color
	[
		'selectors'    => [
			'.woocommerce-remove-coupon',
		],
		'declarations' => [
			'color' => esc_attr( $light ),
		],
	],
	// Solid background-color
	[
		'selectors'    => [
			'.woocommerce-pagination',
			'.facetwp-pager',
		],
		'declarations' => [
			'background-color' => esc_attr( $light ),
		],
	],

	// @mixin card
	[
		'selectors'    => [
			'.woocommerce-checkout-review-order',
			'.woocommerce-message',
			'.woocommerce-info',
			'.woocommerce-purchase-form',
			'.wc_payment_method [type="radio"] label',
			'.woocommerce-verification-required',
		],
		'declarations' => [
			'background-color' => esc_attr( $light ),
			'box-shadow'       => esc_attr( "{$light} 0 1px 2px" ),

			// Since 90% of the values use $light we are filling out the border-color here as well for a unified list.
			'border-color'     => esc_attr( bigbox_hex_to_rgba( bigbox_get_theme_color( 'primary' ), 0.20 ) ),
		],
	],

	// @mixin button--light
	[
		'selectors'    => [],
		'declarations' => [
			'background-color' => esc_attr( $light ),
		],
	],
];

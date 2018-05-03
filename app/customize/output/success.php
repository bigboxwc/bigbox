<?php
/**
 * Config for success color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$success = bigbox_get_theme_color( 'success' );
$rgba10  = bigbox_hex_to_rgba( $success, 0.10 );
$rgba30  = bigbox_hex_to_rgba( $success, 0.30 );
$rgba50  = bigbox_hex_to_rgba( $success, 0.50 );

return [
	// Solid background-color.
	[
		'selectors'    => [
			'.navbar-menu__cart-count',
			'.product__sale',
		],
		'declarations' => [
			'background-color' => esc_attr( $success ),
		],
	],
	// Solid border-color.
	[
		'selectors'    => [
			'.wc_payment_method [type="radio"]:checked + label[for^="payment_method"]:before',
		],
		'declarations' => [
			'border-color' => esc_attr( $success ),
		],
	],
	// Solid color.
	[
		'selectors'    => [
			'.woocommerce-purchase-form .instock',
			'.wc-saved-payment-methods input:checked + label',
		],
		'declarations' => [
			'color' => esc_attr( $success ),
		],
	],

	// @mixin card--primary.
	[
		'selectors'    => [
			'.wc_payment_method [type="radio"]:checked + label[for^="payment_method"]',
		],
		'declarations' => [
			'border-color'     => esc_attr( $rgba50 ),
			'background-color' => esc_attr( $rgba10 ),
			'box-shadow'       => esc_attr( "inset {$rgba10} 0 0 0 3px, {$rgba30} 0 1px 2px" ),

			// Since 90% of the values use $success we are filling out the color here as well for a unified list.
			'color'            => esc_attr( bigbox_get_theme_color( 'gray-700' ) ),
		],
	],

	// @mixin button--success
	[
		'selectors'    => [
			'.checkout-button',
			'#place_order',
			'.single_add_to_cart_button',

			// @todo https://github.com/woocommerce/woocommerce/pull/18533
			'.woocommerce-info .woocommerce-Button',
			'.woocommerce-message .woocommerce-Button',
			'.woocommerce-error li .woocommerce-Button',
			'.woocommerce-info .wc-forward',
			'.woocommerce-message .wc-forward',
			'.woocommerce-error li .wc-forward',
		],
		'declarations' => [
			'background-color' => esc_attr( $success ),
		],
	],
];

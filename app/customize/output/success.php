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
	// Solid color.
	[
		'selectors'    => [
			'.woocommerce-purchase-form p.instock',
			'.wc-saved-payment-methods input:checked + label',
			'.order-status--completed',
			'.wc_payment_method [type="radio"]:checked + label[for^="payment_method"]',
			'.woocommerce-purchase-form .in-stock',
		],
		'declarations' => [
			'color' => esc_attr( $success ),
		],
	],

	// @mixin card--success.
	[
		'selectors'    => [
			'.card.card--success',
			'.wc_payment_method [type="radio"]:checked + label[for^="payment_method"]',

			'.wcpv-registration-message.wcpv-shortcode-registration-success',
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
		'selectors'    => bigbox_customize_get_button_success_selectors(),
		'declarations' => [
			'background-color' => esc_attr( $success ),
		],
	],
];

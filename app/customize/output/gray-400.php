<?php
/**
 * Config for gray-400 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$gray400 = bigbox_get_theme_color( 'gray-400' );

return [
	// Solid border-color
	[
		'selectors'    => [
			'.product__has-variations a:hover',
			'.wc_payment_method [type="radio"] label:before',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray400 ),
		],
	],

	// @mixin button--secondary
	[
		'selectors'    => [
			'table .button',
			'.woocommerce-column--billing-address .edit',
			'.woocommerce-column--shipping-address .edit',
			'.woocommerce-Addresses .edit',
		],
		'declarations' => [
			'background-color' => esc_attr( $gray400 ),
		],
	],
];

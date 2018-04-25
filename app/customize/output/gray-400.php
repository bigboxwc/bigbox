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
			'.wc_payment_method [type="radio"] label:before',
			'.action-list__item--inset',
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
	[
		'selectors'    => [
			'.product__has-variations a:hover',
			'.widget_layered_nav_filters a:hover',
		],
		'declarations' => [
			'border-color' => esc_attr( bigbox_get_theme_color( 'gray-400' ) ),
		],
	],
];

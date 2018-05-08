<?php
/**
 * Config for gray-600 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$gray600 = bigbox_get_theme_color( 'gray-600' );

return [
	// Solid color.
	[
		'selectors'    => [
			'.product__stock',
			'.wc_payment_method .payment_box p',
		],
		'declarations' => [
			'color' => esc_attr( $gray600 ),
		],
	],

	// Solid border-top-color.
	[
		'selectors'    => [
			'.navbar-search__category:after',
		],
		'declarations' => [
			'border-top-color' => esc_attr( $gray600 ),
		],
	],

	// @mixin button--pill.
	[
		'selectors'    => [
			'.product__has-variations a',
			'.widget_layered_nav_filters a',
		],
		'declarations' => [
			'color'            => esc_attr( $gray600 ),
			'background-color' => esc_attr( bigbox_get_theme_color( 'gray-100' ) ),
			'border-color'     => esc_attr( bigbox_get_theme_color( 'gray-300' ) ),
		],
	],
];

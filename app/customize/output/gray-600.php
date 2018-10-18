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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$gray600 = bigbox_get_theme_color( 'gray-600' );
$default = bigbox_get_theme_default_color( 'gray-600' );

if ( $gray600 === $default ) {
	return [];
}

return [
	// Solid color.
	[
		'selectors'    => [
			'.product__stock',
			'.wc_payment_method .payment_box p',
			'.woocommerce-products-header .term-description',
			'.cart_totals .shipping-methods',
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
			'.product__has-variations .button.button--pill',
			'.widget_layered_nav_filters .button.button--pill',
		],
		'declarations' => [
			'color'            => esc_attr( $gray600 ),
			'background-color' => esc_attr( bigbox_get_theme_color( 'gray-100' ) ),
			'border-color'     => esc_attr( bigbox_get_theme_color( 'gray-300' ) ),
		],
	],
];

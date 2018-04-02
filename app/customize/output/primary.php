<?php
/**
 * Config for primary color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$primary = bigbox_get_theme_color( 'primary' );
$rgba20  = bigbox_hex_to_rgba( $primary, 0.20 );

return [
	// Solid background-color
	[
		'selectors'    => [
			'.navbar',
			'.facetwp-facet .facetwp-slider .noUi-connect',
			'.select2-container--default .select2-results__option--highlighted[data-selected]',
			'.widget_price_filter .ui-slider .ui-slider-range',
		],
		'declarations' => [
			'background-color' => esc_attr( $primary ),
		],
	],
	// Solid fill
	[
		'selectors'    => [
			'.navbar-search__submit svg',
		],
		'declarations' => [
			'fill' => esc_attr( $primary ),
		],
	],
	// Solid border-color
	[
		'selectors'    => [
			'.woocommerce-MyAccount-navigation-link.is-active a',
			'.widget_price_filter .ui-slider .ui-slider-handle',
		],
		'declarations' => [
			'border-color' => esc_attr( $primary ),
		],
	],
	// Solid outline-color
	[
		'selectors'    => [
			':focus',
		],
		'declarations' => [
			'outline-color' => esc_attr( $primary ),
		],
	],
	// RGBA 0.25 border-color
	[
		'selectors'    => [
			'.woocommerce-loop-category__title',
		],
		'declarations' => [
			'border-color' => esc_attr( $rgba20 ),
		],
	],

	// @mixin button
	[
		'selectors'    => [
			'.button',
			'button',
			'.woocommerce-form-coupon [name="apply_coupon"]',
		],
		'declarations' => [
			'background-color' => esc_attr( $primary ),
		],
	],
];

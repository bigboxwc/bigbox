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
$rgba15  = bigbox_hex_to_rgba( $primary, 0.15 );
$rgba10  = bigbox_hex_to_rgba( $primary, 0.10 );
$rgba08  = bigbox_hex_to_rgba( $primary, 0.08 );

return [
	// Solid color
	[
		'selectors'    => [
			'a:hover',
			'.navbar-menu--primary .sub-menu a:hover',
		],
		'declarations' => [
			'color' => esc_attr( $primary ),
		],
	],
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
			'.single_variation_wrap',
			'.woocommerce-variation--loaded .woocommerce-variation',
		],
		'declarations' => [
			'border-color' => esc_attr( $rgba20 ),
		],
	],
	// RGBA 0.15 border-color
	[
		'selectors'    => [
			'.woocommerce-loop-category__title',
			'.woocommerce-MyAccount-navigation-link.is-active a',
			'.product-category__more',
		],
		'declarations' => [
			'border-color' => esc_attr( $rgba15 ),
		],
	],
	// RGBA 0.10 border-color
	[
		'selectors'    => [
			'.woocommerce-page ul.products-categories li.product.product-category',
			'.woocommerce ul.products-categories li.product.product-category',
		],
		'declarations' => [
			'border-color' => esc_attr( $rgba10 ),
		],
	],
	// RGBA 0.08 background-color
	[
		'selectors'    => [
			'.woocommerce-page ul.products-categories li.product.product-category',
			'.woocommerce ul.products-categories li.product.product-category',
		],
		'declarations' => [
			'background-color' => esc_attr( $rgba08 ),
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

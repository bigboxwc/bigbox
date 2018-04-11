<?php
/**
 * Config for gray-300 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$gray300    = bigbox_get_theme_color( 'gray-300' );
$gray300_50 = bigbox_hex_to_rgba( $gray300, 0.50 );

return [
	// Solid border-color
	[
		'selectors'    => [
			'.navbar-mobile .sub-menu',
			'.wc-credit-card-form #stripe-card-element',
			'.navbar-search__category select',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray300 ),
		],
	],
	// RGBA .50 border-color
	[
		'selectors'    => [
			'.woocommerce-page ul.products-categories li.product.product-category',
			'.woocommerce ul.products-categories li.product.product-category',
			'.woocommerce-page ul.products-categories:after',
			'.woocommerce ul.products-categories:after',
			'.product-category-more__selector',
			'.product-category-more__inner',
			'.woocommerce-loop-category__title',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray300_50 ),
		],
	],
	// RGBA .50 box-shadow
	[
		'selectors'    => [
		],
		'declarations' => [
			'box-shadow' => '0 1px 0 ' . esc_attr( $gray300 ),
		],
	],

	// @mixin form--input
	[
		'selectors'    => [
			'textarea',
			'[type="email"]',
			'[type="search"]',
			'[type="tel"]',
			'[type="url"]',
			'[type="password"]',
			'[type="text"]',
			'.navbar-search__submit [type="submit"]',
			'.woocommerce .input-text',
			'.select2-container--default .select2-selection--single',
			'.select2-container--default:focus .select2-selection--single',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray300 ),
		],
	],
];

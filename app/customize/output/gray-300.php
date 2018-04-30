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

$gray300 = bigbox_get_theme_color( 'gray-300' );
$rgba50  = bigbox_hex_to_rgba( $gray300, 0.50 );
$rgba75  = bigbox_hex_to_rgba( $gray300, 0.75 );

return [
	// Solid border-color
	[
		'selectors'    => [
			'table td',
			'table th',
			'.navbar-mobile .sub-menu',
			'.wc-credit-card-form #stripe-card-element',
			'.navbar-search__category select',
			'.facetwp-facet.facetwp-type-slider .facetwp-slider .noUi-handle',
			'div#brands_a_z a.top',

			// .form-input
			'.woocommerce .input-text',
			'#stripe-card-element',
			'#stripe-exp-element',
			'#stripe-cvc-element',
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
			'border-color' => esc_attr( $rgba50 ),
		],
	],
	// RGBA .50 box-shadow
	[
		'selectors'    => [],
		'declarations' => [
			'box-shadow' => '0 1px 0 ' . esc_attr( $gray300 ),
		],
	],
	// Solid box-shadow
	[
		'selectors'    => [
			'table',
		],
		'declarations' => [
			'box-shadow' => esc_attr( "{$gray300} 0 0 0 1px" ),
		],
	],

	// @mixin card
	[
		'selectors'    => [
			'.woocommerce-checkout-review-order',
			'.woocommerce-message',
			'.woocommerce-info',
			'.woocommerce-purchase-form',
			'.wc_payment_method [type="radio"] label[for^="payment_method"]',
			'.woocommerce-verification-required',
		],
		'declarations' => [
			'box-shadow'       => esc_attr( "{$rgba50} 0 1px 2px" ),
			'border-color'     => esc_attr( $rgba75 ),

			// To have a unifed mixin.
			'background-color' => esc_attr( bigbox_hex_to_rgba( bigbox_get_theme_color( 'gray-100' ), 0.15 ) ),
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

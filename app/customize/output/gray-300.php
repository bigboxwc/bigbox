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
	// Solid color.
	[
		'selectors'    => [
			'.facetwp-facet.facetwp-facet-rating .facetwp-star',
		],
		'declarations' => [
			'color' => esc_attr( $gray300 ),
		],
	],

	// Solid border-color.
	[
		'selectors'    => [
			'table',
			'table tr',
			'thead',
			'tfoot',
			'.navbar-mobile .sub-menu',
			'.wc-credit-card-form #stripe-card-element',
			'.navbar-search__category select',
			'.widget ul ul',
			'.action-list__item--inset',
			'.shipping-note',

			'.review-breakdown',
			'.review-breakdown__item',

			'div#brands_a_z a.top',
			'ul.brands_index li a',
			'ul.brands_index li span',

			// .form-input.
			'.woocommerce .input-text',
			'#stripe-card-element',
			'#stripe-exp-element',
			'#stripe-cvc-element',

			// Flatpickr.
			'.flatpickr-calendar .flatpickr-day.inRange',
			'.flatpickr-calendar .flatpickr-day.prevMonthDay.inRange',
			'.flatpickr-calendar .flatpickr-day.nextMonthDay.inRange',
			'.flatpickr-calendar .flatpickr-day.today.inRange',
			'.flatpickr-calendar .flatpickr-day.prevMonthDay.today.inRange',
			'.flatpickr-calendar .flatpickr-day.nextMonthDay.today.inRange',
			'.flatpickr-calendar .flatpickr-day:hover',
			'.flatpickr-calendar .flatpickr-day.prevMonthDay:hover',
			'.flatpickr-calendar .flatpickr-day.nextMonthDay:hover',
			'.flatpickr-calendar .flatpickr-day:focus',
			'.flatpickr-calendar .flatpickr-day.prevMonthDay:focus',
			'.flatpickr-calendar .flatpickr-day.nextMonthDay:focus',


			// select2.
			'.select2-container--default .select2-search--dropdown .select2-search__field',
			'.select2-dropdown',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray300 ),
		],
	],
	// RGBA .50 border-color.
	[
		'selectors'    => [
			'.woocommerce-page ul.products-categories li.product.product-category',
			'.woocommerce ul.products-categories li.product.product-category',
			'.woocommerce-page ul.products-categories:after',
			'.woocommerce ul.products-categories:after',
			'.product-category-more__selector',
			'.product-category-more__inner',
			'.woocommerce-loop-category__title',
			'.woocommerce-placeholder',
			'.woocommerce-product-gallery__image--placeholder',
		],
		'declarations' => [
			'border-color' => esc_attr( $rgba50 ),
		],
	],
	// RGBA .50 box-shadow.
	[
		'selectors'    => [
			'.product-category-more__inner',
			'.woocommerce-loop-category__title',
		],
		'declarations' => [
			'box-shadow' => '0 1px 0 ' . esc_attr( $gray300 ),
		],
	],

	// @mixin card.
	[
		'selectors'    => [
			'.card',
			'.woocommerce-checkout-review-order',
			'.woocommerce-message',
			'.woocommerce-info',
			'.wc_payment_method [type="radio"] label[for^="payment_method"]',
			'.woocommerce-verification-required',
			'table',
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

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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$primary = bigbox_get_theme_color( 'primary' );
$rgba20  = bigbox_hex_to_rgba( $primary, 0.20 );

return [
	// Solid color.
	'color'            => [
		'selectors'    => [
			'a:hover',
			'.navbar-menu--primary .sub-menu a:hover',
			'.wc-layered-nav-term.chosen',
			'.wc-layered-nav-term.chosen a',
			'.woocommerce-page ul.products-categories li.product.product-category a:hover h2',
			'.woocommerce ul.products-categories li.product.product-category a:hover h2',

			'.woocommerce-pagination .active',
			'.woocommerce-pagination .current',
			'.facetwp-pager .active',
			'.facetwp-pager .current',
			'.nav-links .active',
			'.nav-links .current',
		],
		'declarations' => [
			'color' => esc_attr( $primary ),
		],
	],

	// Solid background-color.
	'background-color' => [
		'selectors'    => array_merge(
			bigbox_customize_get_button_selectors(),
			[
				'a:hover i.bigbox-icon',
				'.navbar',
				'.select2-container--default .select2-results__option--highlighted[data-selected]',
				'.widget_price_filter .ui-slider .ui-slider-range',

				'.facetwp-facet .facetwp-slider .noUi-connect',
				'.facetwp-template__loading:before',
				'.facetwp-facet .facetwp-submit',
				'.facetwp-facet .facetwp-autocomplete-update',
				'.facetwp-facet .facetwp-slider-reset',
				'.facetwp-facet.facetwp-type-slider .facetwp-slider .noUi-connect',

				// Flatpickr.
				'.flatpickr-calendar .flatpickr-day.selected',
				'.flatpickr-calendar .flatpickr-day.startRange',
				'.flatpickr-calendar .flatpickr-day.endRange',
				'.flatpickr-calendar .flatpickr-day.selected.inRange',
				'.flatpickr-calendar .flatpickr-day.startRange.inRange',
				'.flatpickr-calendar .flatpickr-day.endRange.inRange',
			]
		),
		'declarations' => [
			'background-color' => esc_attr( $primary ),
		],
	],

	// Solid fill.
	'fill'             => [
		'selectors'    => [
			'a:hover .bigbox-icon',
			'.navbar-search__submit svg',
		],
		'declarations' => [
			'fill' => esc_attr( $primary ),
		],
	],

	// Solid border-color.
	'border-color'     => [
		'selectors'    => [
			'.widget_price_filter .ui-slider .ui-slider-handle',
			'.facetwp-facet.facetwp-type-slider .facetwp-slider .noUi-handle',

			'.woocommerce-MyAccount-navigation-link.is-active a',

			// Flatpickr.
			'.flatpickr-calendar .flatpickr-day.selected',
			'.flatpickr-calendar .flatpickr-day.startRange',
			'.flatpickr-calendar .flatpickr-day.endRange',
			'.flatpickr-calendar .flatpickr-day.selected.inRange',
			'.flatpickr-calendar .flatpickr-day.startRange.inRange',
			'.flatpickr-calendar .flatpickr-day.endRange.inRange',
		],
		'declarations' => [
			'border-color' => esc_attr( $primary ),
		],
	],

	// Solid outline-color.
	'outline-color'    => [
		'selectors'    => [
			'.is-tabbing *:focus',
		],
		'declarations' => [
			'outline-color' => esc_attr( $primary ),
		],
	],
];

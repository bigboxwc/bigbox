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
	// Solid color.
	[
		'selectors'    => [
			'a:hover',
			'.navbar-menu--primary .sub-menu a:hover',
			'.wc-layered-nav-term.chosen',
			'.wc-layered-nav-term.chosen a',
		],
		'declarations' => [
			'color' => esc_attr( $primary ),
		],
	],
	// Solid background-color.
	[
		'selectors'    => [
			'.navbar',
			'.facetwp-facet .facetwp-slider .noUi-connect',
			'.select2-container--default .select2-results__option--highlighted[data-selected]',
			'.widget_price_filter .ui-slider .ui-slider-range',

			// Flatpickr.
			'.flatpickr-calendar .flatpickr-day.selected',
			'.flatpickr-calendar .flatpickr-day.startRange',
			'.flatpickr-calendar .flatpickr-day.endRange',
			'.flatpickr-calendar .flatpickr-day.selected.inRange',
			'.flatpickr-calendar .flatpickr-day.startRange.inRange',
			'.flatpickr-calendar .flatpickr-day.endRange.inRange',
		],
		'declarations' => [
			'background-color' => esc_attr( $primary ),
		],
	],
	// Solid fill.
	[
		'selectors'    => [
			'a:hover .bigbox-icon',
			'.navbar-search__submit svg',
		],
		'declarations' => [
			'fill' => esc_attr( $primary ),
		],
	],
	// Solid border-color.
	[
		'selectors'    => [
			'.widget_price_filter .ui-slider .ui-slider-handle',
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
	[
		'selectors'    => [
			':focus',
		],
		'declarations' => [
			'outline-color' => esc_attr( $primary ),
		],
	],

	// @mixin button.
	[
		'selectors'    => [
			'.button',
			'button',
			'.woocommerce-form-coupon [name="apply_coupon"]',
			'.comment-form [type="submit"]',
		],
		'declarations' => [
			'background-color' => esc_attr( $primary ),
		],
	],
];

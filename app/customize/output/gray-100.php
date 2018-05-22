<?php
/**
 * Config for gray-100 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$gray100 = bigbox_get_theme_color( 'gray-100' );

return [
	// Solid background-color.
	[
		'selectors'    => [
			'table tbody tr:nth-child(even) th',
			'table tbody tr:nth-child(even) td',
			'.footer-copyright',
			'.navbar-mobile__close',
			'.breadcrumbs',
			'.woocommerce-breadcrumb',
			'.navbar-search__category select',

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
			'.select2-container--default .select2-results__option[aria-selected=true]',
			'.select2-container--default .select2-results__option[data-selected=true]',
		],
		'declarations' => [
			'background-color' => esc_attr( $gray100 ),
		],
	],
	// Solid border-color.
	[
		'selectors'    => [
			'.footer-nav',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray100 ),
		],
	],
];

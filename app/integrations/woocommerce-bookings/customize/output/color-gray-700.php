<?php
/**
 * Config for Gray 200 color output.
 *
 * @since 1.16.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$gray700 = bigbox_get_theme_color( 'gray-700' );

return [
	[
		'selectors'    => [
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-header',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-next:before',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-prev:before',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-calendar th',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker td.partial_booked a',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker td.bookable a:not(.ui-state-active)',
			'.wc-bookings-booking-form .wc-bookings-booking-cost',
		],
		'declarations' => [
			'color' => esc_attr( $gray700 ) . ' !important',
		],
	],
];

<?php
/**
 * Config for Gray 300 color output.
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

$gray300 = bigbox_get_theme_color( 'gray-300' );

return [
	[
		'selectors'    => [
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-header',
			'.wc-bookings-booking-form .form-field ul.block-picker li:nth-child(even) a',
			'.wc-bookings-booking-form .form-field ul.block-picker li:nth-child(odd) a',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-calendar td',
			'.wc-bookings-booking-form .wc-bookings-booking-cost',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray300 ),
		],
	],
];

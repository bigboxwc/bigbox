<?php
/**
 * Config for success color output.
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

$success = bigbox_get_theme_color( 'success' );
$default = bigbox_get_theme_default_color( 'success' );

if ( $success === $default ) {
	return [];
}

return [
	[
		'selectors'    => [
			'.wc-bookings-booking-form .form-field ul.block-picker li:nth-child(even) a:hover',
			'.wc-bookings-booking-form .form-field ul.block-picker li:nth-child(odd) a:hover',
			'.wc-bookings-booking-form .form-field ul.block-picker li a.selected',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker td.ui-datepicker-current-day a',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker td.ui-datepicker-current-day a:hover',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-calendar td.bookable-range .ui-state-default',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-calendar td.bookable-range .ui-state-default:hover',
		],
		'declarations' => [
			'background-color' => esc_attr( $success ) . ' !important',
		],
	],
	[
		'selectors'    => [
			'.wc-bookings-booking-form .form-field ul.block-picker li:nth-child(even) a:hover',
			'.wc-bookings-booking-form .form-field ul.block-picker li:nth-child(odd) a:hover',
			'.wc-bookings-booking-form .form-field ul.block-picker li a.selected',
		],
		'declarations' => [
			'border-color' => esc_attr( $success ) . ' !important',
		],
	],
];

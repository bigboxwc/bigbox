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

$gray200 = bigbox_get_theme_color( 'gray-200' );
$default = bigbox_get_theme_default_color( 'gray-200' );

if ( $gray200 === $default ) {
	return [];
}

return [
	[
		'selectors'    => [
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-header',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker td.ui-datepicker-today a:hover',
			'.wc-bookings-booking-form .wc-bookings-booking-cost',
		],
		'declarations' => [
			'background-color' => esc_attr( $gray200 ),
		],
	],
];

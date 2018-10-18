<?php
/**
 * Config for type output.
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

$size = get_theme_mod( 'type-font-size', 1 );

$weight_base = bigbox_get_theme_font_weight( 'base' );
$weight_bold = bigbox_get_theme_font_weight( 'bold' );

if ( 'regular' === $weight_base ) {
	$weight_base = 'normal';
}

// Force a browser-rendered bold weight.
if ( 'regular' === $weight_bold ) {
	$weight_bold = 'bold';
}

return [
	[
		'selectors'    => [
			'.wc-bookings-booking-form',
			'.wc-bookings-booking-form .ui-widget',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker table',
		],
		'declarations' => [
			'font-weight' => esc_attr( $weight_base ),
			'font-size'   => esc_attr( "{$size}em" ),
		],
	],
	[
		'selectors'    => [
			'.wc-bookings-booking-form fieldset legend .label',
			'.wc-bookings-booking-form .form-field label',
		],
		'declarations' => [
			'font-weight' => esc_attr( $weight_bold ),
		],
	],
];

<?php
/**
 * WooCommerce Bookings template functions.
 *
 * @since 1.16.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Point Bookings template overrides to our custom directory.
 *
 * @param string $template Current template path.
 * @param string $template_name Current template name.
 * @return string
 */
function bigbox_woocommerce_bookings_locate_template( $template, $template_name ) {
	$overrides = [
		'booking-form/number.php',
		'booking-form/select.php',
	];

	if ( in_array( $template_name, $overrides, true ) ) {
		return get_theme_file_path( 'resources/views/integrations/woocommerce-bookings/' . $template_name );
	};

	return $template;
}

/**
 * Enqueue styles.
 *
 * @since 1.16.0
 */
function bigbox_woocommerce_bookings_enqueue_styles() {
	$version    = bigbox_get_theme_version();
	$parent     = bigbox_get_theme_name();
	$stylesheet = $parent . '-woocommerce-bookings';

	wp_enqueue_style(
		$stylesheet,
		get_template_directory_uri() . '/public/css/woocommerce-bookings.min.css',
		[],
		$version
	);

	wp_style_add_data(
		$stylesheet,
		'rtl',
		'replace'
	);
}

/**
 * Add additional CSS to the "Primary" color inline CSS.
 *
 * @since 1.16.0
 *
 * @param array $data CSS data.
 * @return array
 */
function bigbox_woocomerce_bookings_customize_inline_css_primary( $data ) {
	$success = bigbox_get_theme_color( 'success' );

	$data[] = [
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
	];

	$data[] = [
		'selectors'    => [
			'.wc-bookings-booking-form .form-field ul.block-picker li:nth-child(even) a:hover',
			'.wc-bookings-booking-form .form-field ul.block-picker li:nth-child(odd) a:hover',
			'.wc-bookings-booking-form .form-field ul.block-picker li a.selected',
		],
		'declarations' => [
			'border-color' => esc_attr( $success ) . ' !important',
		],
	];

	return $data;
}

/**
 * Add additional CSS to the "Gray 200" color inline CSS.
 *
 * @since 1.16.0
 *
 * @param array $data CSS data.
 * @return array
 */
function bigbox_woocomerce_bookings_customize_inline_css_gray_200( $data ) {
	$gray200 = bigbox_get_theme_color( 'gray-200' );

	$data[] = [
		'selectors'    => [
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-header',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker td.ui-datepicker-today a:hover',
			'.wc-bookings-booking-form .wc-bookings-booking-cost',
		],
		'declarations' => [
			'background-color' => esc_attr( $gray200 ),
		],
	];

	return $data;
}

/**
 * Add additional CSS to the "Gray 300" color inline CSS.
 *
 * @since 1.16.0
 *
 * @param array $data CSS data.
 * @return array
 */
function bigbox_woocomerce_bookings_customize_inline_css_gray_300( $data ) {
	$gray300 = bigbox_get_theme_color( 'gray-300' );

	$data[] = [
		'selectors'    => [
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-header',
			'.wc-bookings-booking-form .form-field ul.block-picker li:nth-child(even) a',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-calendar td',
			'.wc-bookings-booking-form .wc-bookings-booking-cost',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray300 ),
		],
	];

	return $data;
}

/**
 * Add additional CSS to the "Gray 700" color inline CSS.
 *
 * @since 1.16.0
 *
 * @param array $data CSS data.
 * @return array
 */
function bigbox_woocomerce_bookings_customize_inline_css_gray_700( $data ) {
	$gray700 = bigbox_get_theme_color( 'gray-700' );

	$data[] = [
		'selectors'    => [
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-header',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-next:before',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-prev:before',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker-calendar th',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker td.ui-datepicker-today a',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker td.partial_booked a',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker td.bookable a:not(.ui-state-active)',
			'.wc-bookings-booking-form .wc-bookings-booking-cost',
		],
		'declarations' => [
			'color' => esc_attr( $gray700 ) . ' !important',
		],
	];

	return $data;
}

/**
 * Add additional CSS to the "Type" inline CSS.
 *
 * @since 1.16.0
 *
 * @param array $data CSS data.
 * @return array
 */
function bigbox_woocomerce_bookings_customize_inline_css_type( $data ) {
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

	$data[] = [
		'selectors'    => [
			'.wc-bookings-booking-form',
			'.wc-bookings-booking-form .ui-widget',
			'.wc-bookings-booking-form .wc-bookings-date-picker .ui-datepicker table',
		],
		'declarations' => [
			'font-weight' => esc_attr( $weight_base ),
			'font-size'   => esc_attr( "{$size}em" ),
		],
	];

	$data[] = [
		'selectors'    => [
			'.wc-bookings-booking-form fieldset legend .label',
			'.wc-bookings-booking-form .form-field label',
		],
		'declarations' => [
			'font-weight' => esc_attr( $weight_bold ),
		],
	];

	return $data;
}

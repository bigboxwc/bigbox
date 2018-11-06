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

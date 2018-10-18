<?php
/**
 * WooCommerce Bookings template hooks.
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

// Filter template loading.
add_filter( 'woocommerce_locate_template', 'bigbox_woocommerce_bookings_locate_template', 10, 2 );

// Assets.
add_action( 'wp_enqueue_scripts', 'bigbox_woocommerce_bookings_enqueue_styles' );
add_filter( 'bigbox_customize_inline_css_primary', 'bigbox_woocomerce_bookings_customize_inline_css_primary' );
add_filter( 'bigbox_customize_inline_css_type', 'bigbox_woocomerce_bookings_customize_inline_css_type' );
add_filter( 'bigbox_customize_inline_css_gray-300', 'bigbox_woocomerce_bookings_customize_inline_css_gray_300' );
add_filter( 'bigbox_customize_inline_css_gray-300', 'bigbox_woocomerce_bookings_customize_inline_css_gray_700' );

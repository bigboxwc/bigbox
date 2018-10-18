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

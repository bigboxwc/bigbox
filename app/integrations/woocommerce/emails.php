<?php
/**
 * WooCommerce email modifications.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Use customizer settings for emails.
add_filter( 'option_woocommerce_email_base_color', function( $value ) {
	return bigbox_get_theme_color( 'primary' );
} );

add_filter( 'option_woocommerce_email_background_color', function( $value ) {
	return bigbox_get_theme_color( 'gray-100' );
} );

add_filter( 'woocommerce_email_text_color', function( $value ) {
	return bigbox_get_theme_color( 'gray-700' );
} );

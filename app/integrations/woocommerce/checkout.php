<?php
/**
 * WooCommerce checkout modifications.
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

// Allow these modifications to easily be removed.
if ( apply_filters( 'bigbox_optimize_checkout', true ) ) {

	// Rearrange review, payment, and totals.
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
	add_action( 'woocommerce_checkout_before_customer_details', 'woocommerce_checkout_payment', 20 );
}

/**
 * Update "Billing details" text string.
 *
 * @since 1.0.0
 *
 * @param string $translation Translated string.
 * @param string $original Original string.
 * @param string $domain Text domain.
 */
function bigbox_woocommerce_billing_details_title( $translation, $original, $domain ) {
	if ( 'woocommerce' !== $domain ) {
		return $translation;
	}

	if ( 'Billing details' === $original ) {
		return esc_html__( '2. Billing Details', 'bigbox' );
	}

	if ( 'Billing &amp; Shipping' === $original ) {
		return esc_html__( '2. Billing &amp; Shipping', 'bigbox' );
	}

	return $translation;
}
add_filter( 'gettext', 'bigbox_woocommerce_billing_details_title', 10, 3 );

/**
 * Get cart review HTML.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_get_cart_review_html() {
	ob_start();

	if ( WC()->cart->is_empty() ) {
		wc_get_template( 'cart/cart-empty.php' );
	} else {
		wc_get_template( 'checkout/review-order.php' );
	}

	return ob_get_clean();
}

/**
 * Update cart review data via AJAX.
 *
 * @todo check nonce.
 * @since 1.0.0
 */
function bigbox_update_cart_review() {
	bigbox_update_cart_and_totals();

	if ( ! defined( 'WOOCOMMERCE_CHECKOUT' ) ) {
		define( 'WOOCOMMERCE_CHECKOUT', true );
	}

	$json = wp_send_json_success(
		[
			'data' => [
				'review' => bigbox_get_cart_review_html(),
			],
		]
	);

	define( 'WOOCOMMERCE_CHECKOUT', false );

	return $json;
}
add_action( 'wp_ajax_nopriv_bigbox_update_cart_review', 'bigbox_update_cart_review' );
add_action( 'wp_ajax_bigbox_update_cart_review', 'bigbox_update_cart_review' );

<?php
/**
 * WooCommerce checkout functions.
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

	// Update checkout fields.
	add_filter( 'woocommerce_billing_fields', 'bigbox_woocommerce_billing_fields' );
	add_filter( 'woocommerce_default_address_fields', 'bigbox_woocommerce_default_address_fields' );
	
	// Rearrange review, payment, and totals.
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
	add_action( 'woocommerce_checkout_before_customer_details', 'woocommerce_checkout_payment', 20 );

	add_action( 'woocommerce_checkout_before_order_review', 'woocommerce_order_review' );

	add_action( 'woocommerce_checkout_order_review', function() {
		wc_get_template( 'cart/cart-totals.php' );
	}, 30 );

	add_action( 'woocommerce_checkout_order_review', function() {
		wc_get_template( 'checkout/submit.php' );
	}, 40 );

	// Remove coupons/login.
	// @todo output again.
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}

/**
 * Adjust order for billing form fields.
 *
 * @since 1.0.0
 *
 * @param array $fields Billing fields.
 * @return array
 */
function bigbox_woocommerce_billing_fields( $fields ) {
	// Move email under name.
	$fields['billing_email']['priority'] = 23;

	// Remove phone.
	unset( $fields['billing_phone'] );

	return $fields;
}

/**
 * Adjust columns for billing form fields.
 *
 * @since 1.0.0
 *
 * @param array $fields Current billing fields.
 * @return array
 */
function bigbox_woocommerce_default_address_fields( $fields ) {
	$fields['address_1']['class'][] = 'form-row-first';
	$fields['address_2']['class'][] = 'form-row-last';
	$fields['address_2']['label']   = __( 'Apartment, suite, etc', 'bigbox' );

	$fields['state']['priority'] = 41;

	// Remove wide from some that can be collapsed.
	foreach ( array( 'address_1', 'address_2', 'city', 'postcode' ) as $field ) {
		$key = array_search( 'form-row-wide', $fields[ $field ]['class'], true );

		if ( false !== $key ) {
			unset( $fields[ $field ]['class'][ $key ] );
		}
	}

	$fields['city']['class'][]     = 'form-row-first';
	$fields['postcode']['class'][] = 'form-row-last';

	// Remove company.
	unset( $fields['company'] );

	return $fields;
}


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
				'totals' => bigbox_get_totals_html(),
			],
		]
	);

	define( 'WOOCOMMERCE_CHECKOUT', false );

	return $json;
}
add_action( 'wp_ajax_nopriv_bigbox_update_cart_review', 'bigbox_update_cart_review' );
add_action( 'wp_ajax_bigbox_update_cart_review', 'bigbox_update_cart_review' );

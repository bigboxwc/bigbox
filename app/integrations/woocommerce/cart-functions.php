<?php
/**
 * WooCommerce cart functions.
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

/**
 * Update cart data via AJAX.
 *
 * @todo check nonce.
 * @since 1.0.0
 */
function bigbox_update_cart() {
	$values = array();
	parse_str( $_POST['checkout'], $values );

	$cart = $values['cart'];

	foreach ( $cart as $cart_key => $cart_value ) {
		$qty = (int) $cart_value['qty'];

		// Remove from cart if setting to 0
		if ( 0 === $qty ) {
			WC()->cart->remove_cart_item( $cart_key );

			continue;
		}

		WC()->cart->set_quantity( $cart_key, $qty );
	}

	WC()->cart->calculate_totals();

	// Get cart.
	ob_start();

	if ( WC()->cart->is_empty() ) {
		wc_get_template( 'cart/cart-empty.php' );
	} else {
		wc_get_template( 'cart/cart.php' );
	}

	$cart = ob_get_clean();

	// Get totals
	ob_start();

	woocommerce_cart_totals();

	$totals = ob_get_clean();

	return wp_send_json_success( [
		'data' => [
			'cart'   => $cart,
			'totals' => $totals,
		]
	] );
}
add_action( 'wp_ajax_nopriv_bigbox_update_cart', 'bigbox_update_cart' );
add_action( 'wp_ajax_bigbox_update_cart', 'bigbox_update_cart' );

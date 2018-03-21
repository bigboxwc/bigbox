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
 * Get a shipping price.
 *
 * @since 1.0.0
 *
 * @param WC_Shipping_Rate $method Shipping method rate data.
 * @return false|string
 */
function bigbox_woocommerce_cart_shipping_method_price( $method ) {
	$price = false;

	if ( $method->cost >= 0 && $method->get_method_id() !== 'free_shipping' ) {
		if ( WC()->cart->display_prices_including_tax() ) {
			$price = wc_price( $method->cost + $method->get_shipping_tax() );
		} else {
			$price = wc_price( $method->cost );
		}
	}

	return $price;
}

/**
 * Get a shipping methods full label including price.
 *
 * @since 1.0.0
 *
 * @param string           $label Current label output.
 * @param WC_Shipping_Rate $method Shipping method rate data.
 * @return string
 */
function bigbox_woocommerce_cart_shipping_method_full_label( $label, $method ) {
	$label = $method->get_label() . ':';

	if ( $method->cost >= 0 && $method->get_method_id() !== 'free_shipping' ) {
		$label .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
	}

	return $label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'bigbox_woocommerce_cart_shipping_method_full_label', 10, 2 );

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

<?php
/**
 * WooCommerce cart modifications.
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

			if ( $method->get_shipping_tax() > 0 && wc_prices_include_tax() ) {
				$price .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
			}
		} else {
			$price = wc_price( $method->cost );

			if ( $method->get_shipping_tax() > 0 && ! wc_prices_include_tax() ) {
				$price .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
			}
		}
	}

	return $price ? $price : wc_price( 0 );
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
	return $method->get_label();
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'bigbox_woocommerce_cart_shipping_method_full_label', 5, 2 );

/**
 * Better formatting for fees in cart.
 *
 * @since 1.12.0
 *
 * @param string $fee_html Original HTML string.
 * @param object $fee Fee.
 * @return string
 */
function bigbox_woocommerce_cart_totals_fee_html( $fee_html, $fee ) {
	if ( $fee->total >= 0 ) {
		$fee_html = '<span class="woocommerce-totals-plus">&plus; </span>' . $fee_html;
	} else {
		$fee_html = '<span class="woocommerce-totals-plus">&ndash;&nbsp;</span>' . str_replace( '-', '', $fee_html );
	}

	return $fee_html;
}
add_filter( 'woocommerce_cart_totals_fee_html', 'bigbox_woocommerce_cart_totals_fee_html', 10, 2 );

/**
 * Update global cart and totals.
 *
 * Note: This should not be called directly. It should be inside a previously
 * secured AJAX request.
 *
 * @since 1.0.0
 */
function bigbox_update_cart_and_totals() {
	$values = [];

	parse_str( $_POST['checkout'], $values ); // @codingStandardsIgnoreLine

	$cart = wp_unslash( $values['cart'] );

	foreach ( $cart as $cart_key => $cart_value ) {
		$qty = absint( $cart_value['qty'] );

		// Remove from cart if setting to 0.
		if ( 0 === $qty ) {
			WC()->cart->remove_cart_item( $cart_key );

			continue;
		}

		WC()->cart->set_quantity( $cart_key, $qty );
	}

	WC()->cart->calculate_totals();
}

/**
 * Get cart HTML.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_get_cart_html() {
	ob_start();

	if ( WC()->cart->is_empty() ) {
		wc_get_template( 'cart/cart-empty.php' );
	} else {
		wc_get_template( 'cart/cart.php' );
	}

	return ob_get_clean();
}

/**
 * Get totals HTML.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_get_totals_html() {
	ob_start();

	wc_get_template( 'cart/cart-totals.php' );

	return ob_get_clean();
}

/**
 * Update cart data via AJAX.
 *
 * @since 1.0.0
 */
function bigbox_update_cart() {
	if ( ! check_ajax_referer( 'woocommerce-cart', '_wpnonce', false ) ) {
		return wp_send_json_error();
	}

	bigbox_update_cart_and_totals();

	return wp_send_json_success(
		[
			'data' => [
				'cart'   => bigbox_get_cart_html(),
				'totals' => bigbox_get_totals_html(),
			],
		]
	);
}
add_action( 'wp_ajax_nopriv_bigbox_update_cart', 'bigbox_update_cart' );
add_action( 'wp_ajax_bigbox_update_cart', 'bigbox_update_cart' );

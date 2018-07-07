<?php
/**
 * Cart view in checkout.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<ul class="products products-main columns-1">
	<?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>

	<?php
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
		wc_get_template(
			'cart/cart-item.php', [
				'cart_item_key' => $cart_item_key,
				'cart_item'     => $cart_item,
			]
		);
	endforeach;
	?>

	<?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>
</ul>

<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form id="bigbox-cart" class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<?php do_action( 'woocommerce_before_cart_contents' ); ?>

	<ul class="products columns-1">

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
			wc_get_template( 'cart/cart-item.php', [
				'cart_item_key' => $cart_item_key,
				'cart_item'     => $cart_item,
			] );
		endforeach;
		?> 

		<?php do_action( 'woocommerce_cart_contents' ); ?>

	</ul>

	<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

	<?php do_action( 'woocommerce_cart_actions' ); ?>
	<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>

	<div class="cart-collaterals">
		<?php
			/**
			* Cart collaterals hook.
			*
			* @hooked woocommerce_cross_sell_display
			* @hooked woocommerce_cart_totals - 10
			*/
			do_action( 'woocommerce_cart_collaterals' );
		?>
	</div>
</form>

<?php do_action( 'woocommerce_after_cart' ); ?>

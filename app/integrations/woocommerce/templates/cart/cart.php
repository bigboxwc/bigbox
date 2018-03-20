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
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if (
				! $_product ||
				! $_product->exists() ||
				$cart_item['quantity'] === 0
				|| ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
					continue;
			endif;

			$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
			$product_thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
		?>

			<li class="product">
				<div class="product__inner">

					<?php if ( $product_thumbnail ) : ?>
					<div class="product__preview">
						<a href="<?php echo esc_url( $product_permalink ); ?>">
							<?php echo wp_kses_post( $product_thumbnail ); ?>
						</a>
					</div>
					<?php endif; ?>

					<div class="product__description">
						<h2 class="product__title">
							<a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo esc_html( $_product->get_name() ); ?>
							</a>
						</h2>

						<div class="product__stats">
							<?php echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok. ?>
						</div>

						<?php if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) : ?>
						<div class="product__stats stock">
							<?php esc_html_e( 'Available on backorder', 'bigbox' ); ?>
						</div>
						<?php endif; ?>

						<div class="product__stats price">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>

							<del class="subtotal">
							<?php
							printf(
								'%s &times %s', 
								$cart_item['quantity'],
								apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) // PHPCS: XSS ok.
							);
							?>
							</del>
						</div>

						<div class="product__stats">
							<?php
							wc_get_template( 'single-product/add-to-cart/quantity.php', [
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'input_id'     => "cart-{$cart_item_key}",
								'step'         => 1,
								'pattern'      => '',
								'inputmode'    => '',
								'max_value'    => $_product->is_sold_individually() ? 1 : $_product->get_max_purchase_quantity(),
								'min_value'    => '0',
								'product_name' => $_product->get_name(),
							] );
							?>
						</div>

					</div>

				</div>
			</li>

		<?php endforeach; ?>

		<?php do_action( 'woocommerce_cart_contents' ); ?>

	</ul>

	<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

	<?php do_action( 'woocommerce_cart_actions' ); ?>
	<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

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

<?php do_action( 'woocommerce_after_cart' ); ?>

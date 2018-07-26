<?php
/**
 * Cart item.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-item.php
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
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

if (
	! $_product ||
	! $_product->exists() ||
	0 === $cart_item['quantity']
	|| ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
		return;
endif;

$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
?>

<li class="product product--cart-item">
	<div class="product__inner">

		<?php
		if ( bigbox_woocommerce_has_product_image( $_product ) ) :
			$product_thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
		?>
		<div class="product__preview">
			<a href="<?php echo esc_url( $product_permalink ); ?>">
				<?php echo $product_thumbnail; // WPCS: XSS okay. ?>
			</a>
		</div>
		<?php endif; ?>

		<div class="product__description">
			<h2 class="product__title">
				<a href="<?php echo esc_url( $product_permalink ); ?>">
					<?php echo esc_html( $_product->get_name() ); ?>
				</a>
			</h2>

			<?php if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) : ?>
			<div class="product__meta stock">
				<?php esc_html_e( 'Available on backorder', 'bigbox' ); ?>
			</div>
			<?php endif; ?>

			<div class="product__meta price">
				<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>

				<del class="subtotal">
				<?php
				if ( 1 !== absint( $cart_item['quantity'] ) ) :
					printf(
						/* translators: %1$s cart item quantity. %2$s Cart item price. */
						__( '%1$s &times %2$s', 'bigbox' ),
						absint( $cart_item['quantity'] ),
						apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) // PHPCS: XSS ok.
					); // WPCS: XSS okay.
				endif;
				?>
				</del>
			</div>

			<div class="product__meta quantity">
				<span class="product__meta-label"><?php esc_html_e( 'Quantity:', 'bigbox' ); ?></span>

				<?php
				wc_get_template(
					'single-product/add-to-cart/quantity.php', [
						'input_name'   => "cart[{$cart_item_key}][qty]",
						'input_value'  => $cart_item['quantity'],
						'input_id'     => "cart-{$cart_item_key}",
						'step'         => 1,
						'pattern'      => '',
						'inputmode'    => '',
						'max_value'    => $_product->is_sold_individually() ? 1 : $_product->get_max_purchase_quantity(),
						'min_value'    => '0',
						'product_name' => $_product->get_name(),
					]
				);
				?>
			</div>

			<?php
			$data = wc_get_formatted_cart_item_data( $cart_item );
			if ( '' !== $data ) :
			?>
			<div class="product__meta">
				<?php echo $data; // PHPCS: XSS ok. ?>
			</div>
			<?php endif; ?>

		</div>

	</div>
</li>

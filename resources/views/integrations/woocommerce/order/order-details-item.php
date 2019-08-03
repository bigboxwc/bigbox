<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
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
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}

$is_visible        = $product && $product->is_visible();
$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );
?>

<li class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'product product--order-item', $item, $order ) ); ?>">
	<div class="product__inner">

		<?php if ( bigbox_woocommerce_has_product_image( $product ) ) : ?>
		<div class="product__preview">
			<?php
			if ( $product_permalink ) :
				printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $product->get_image() ); // WPCS: XSS okay.
			else :
				echo $product->get_image(); // WPCS: XSS okay.
			endif;
			?>
		</div>
		<?php endif; ?>

		<div class="product__description">

			<h2 class="product__title">
				<?php echo apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), esc_html( $item->get_name() ) ) : $item->get_name(), $item, $is_visible ); // WPCS: XSS okay. ?>
			</h2>

			<div class="product__meta price">
				<?php echo $order->get_formatted_line_subtotal( $item ); // WPCS: XSS okay. ?>

				<del class="subtotal">
					<?php
					$qty          = $item->get_quantity();
					$refunded_qty = $order->get_qty_refunded_for_item( $item_id );

					if ( $refunded_qty ) {
						$qty_display = esc_html( $qty ) . '&nbsp;<strike>&nbsp;' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '&nbsp;</strike>';
					} else {
						$qty_display = esc_html( $qty );
					}

					echo apply_filters( 'woocommerce_order_item_quantity_html', sprintf( '&times; %s', $qty_display ), $item ); // WPCS: XSS okay. ?>
				</del>
			</div>

			<?php
			do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

			wc_display_item_meta( $item );

			if ( $show_purchase_note && $purchase_note ) :
				echo wp_kses_post( wpautop( do_shortcode( $purchase_note ) ) );
			endif;

			do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
			?>
		</div>

	</div>
</li>

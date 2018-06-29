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
 * @version 3.0.0
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
				echo wp_kses_post( sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $product->get_image() ) );
			else :
				echo wp_kses_post( $product->get_image() );
			endif;
			?>
		</div>
		<?php endif; ?>

		<div class="product__description">

			<h2 class="product__title">
				<?php echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible ) ); ?>
			</h2>

			<div class="product__meta price">
				<?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>

				<del class="subtotal">
					<?php echo wp_kses_post( apply_filters( 'woocommerce_order_item_quantity_html', sprintf( '&times; %s', $item->get_quantity() ), $item ) ); ?>
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

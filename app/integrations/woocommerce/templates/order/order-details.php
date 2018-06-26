<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
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

$order = wc_get_order( $order_id );

if ( ! $order ) :
	return;
endif;

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', [ 'completed', 'processing' ] ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();
?>

<div class="woocommerce-receipt-wrapper">

	<div class="woocommerce-receipt-wrapper__content">
		<?php
		if ( $show_downloads ) :
			wc_get_template(
				'order/order-downloads.php', [
					'downloads'  => $downloads,
					'show_title' => true,
				]
			);
		endif;
		?>

		<section class="woocommerce-order-details">
			<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

			<ul class="products products-main columns-1">
			<?php
			do_action( 'woocommerce_order_details_before_order_table_items', $order );

			foreach ( $order_items as $item_id => $item ) :
				$product = $item->get_product();

				wc_get_template(
					'order/order-details-item.php', [
						'order'              => $order,
						'item_id'            => $item_id,
						'item'               => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'      => $product ? $product->get_purchase_note() : '',
						'product'            => $product,
					]
				);
			endforeach;

			do_action( 'woocommerce_order_details_after_order_table_items', $order );
			?>
			</ul>

			<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
				<tfoot>
					<?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( $total['label'] ); ?></th>
							<td><?php echo esc_html( $total['value'] ); ?></td>
						</tr>
					<?php endforeach; ?>

					<?php if ( $order->get_customer_note() ) : ?>
						<tr>
							<th><?php esc_html_e( 'Note:', 'bigbox' ); ?></th>
							<td><?php echo wp_kses_post( wptexturize( $order->get_customer_note() ) ); ?></td>
						</tr>
					<?php endif; ?>
				</tfoot>
			</table>

			<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
		</section>
	</div>

	<?php if ( $show_customer_details ) : ?>
	<div class="woocommerce-receipt-wrapper__info">
		<?php wc_get_template( 'order/order-details-customer.php', [ 'order' => $order ] ); ?>
	</div>
	<?php endif; ?>
</div>

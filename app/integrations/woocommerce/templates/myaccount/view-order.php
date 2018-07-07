<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
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
?>

<p class="woocommerce-view-order-status">
<?php
	echo wp_kses_post(
		sprintf(
			/* translators: 1: order date 2: order status. */
			esc_html__( 'Your order placed on %1$s and is currently %2$s.', 'bigbox' ),
			'<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>',
			'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
		)
	);
?>
</p>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>

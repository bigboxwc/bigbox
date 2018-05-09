<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
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
?>

<?php if ( $notes = $order->get_customer_order_notes() ) : ?>
<section class="woocommerce-order-notes">

	<h3 class="widget-title"><?php _e( 'Order Updates', 'bigbox' ); ?></h3>

	<ol class="woocommerce-OrderUpdates">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate">
			<p class="woocommerce-OrderUpdate-meta meta">
			<?php
			echo esc_attr(
				sprintf(
					// Translators: %1$s: Date, %2$s: Time
					 __( '%1$s at %2$s', 'bigbox' ),
					date_i18n( get_option( 'date_format' ), strtotime( $note->comment_date ) ),
					date_i18n( get_option( 'time_format' ), strtotime( $note->comment_date ) )
				)
			);
			?>
			</p>

			<div class="woocommerce-OrderUpdate-description description">
				<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>

</section>
<?php endif; ?>

<section class="woocommerce-customer-details">

	<h3 class="widget-title"><?php _e( 'Billing Address', 'bigbox' ); ?></h3>

	<address>
		<?php echo wp_kses_post( $order->get_formatted_billing_address( __( 'N/A', 'bigbox' ) ) ); ?>

		<?php if ( $order->get_billing_phone() ) : ?>
			<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
		<?php endif; ?>

		<?php if ( $order->get_billing_email() ) : ?>
			<p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
		<?php endif; ?>
	</address>

	<h2 class="widget-title"><?php _e( 'Shipping Address', 'bigbox' ); ?></h2>

	<address>
		<?php echo wp_kses_post( $order->get_formatted_shipping_address( __( 'N/A', 'bigbox' ) ) ); ?>
	</address>

</section>

<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
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
 * @version 2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="bigbox-cart-totals" class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<div class="action-list">

		<div class="action-list__item">
			<div id="subtotal" class="action-list__item-label">
				<?php esc_html_e( 'Subtotal:', 'bigbox' ); ?>
			</div>

			<div class="action-list__item-value action-list__item-value--no-flex" aria-labelledby="subtotal">
				<?php wc_cart_totals_subtotal_html(); ?>
			</div>
		</div>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

		<div class="action-list__item">
			<div id="shipping" class="shipping action-list__item-label">
				<?php esc_html_e( 'Shipping:', 'bigbox' ); ?>
			</div>
			<div>
				<button class="shipping-calculator-button button--text"><?php esc_html_e( 'Calculate shipping', 'bigbox' ); ?></button>
			</div>
		</div>

		<div labelledby="shipping"><?php woocommerce_shipping_calculator(); ?></div>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div id="coupons" class="action-list__item cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<div class="action-list__item-label" id="coupon-<?php echo esc_attr( $code ); ?>">
					<?php wc_cart_totals_coupon_label( $coupon ); ?>
				</div>
				<div class="action-list__item-value action-list__item-value--no-flex" aria-labelledby="coupon-<?php echo esc_attr( $code ); ?>">
					<?php wc_cart_totals_coupon_html( $coupon ); ?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="action-list__item" class="fee">
				<div id="fee-<?php echo esc_attr( $fee->name ); ?>" class="action-list__item-label">
					<?php echo esc_html( $fee->name ); ?>:
				</div>
				<div class="action-list__item-value" labelledby="fee-<?php echo esc_attr( $fee->name ); ?>">
					<span class="woocommerce-totals-plus">&plus; </span>
					<?php wc_cart_totals_fee_html( $fee ); ?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) :
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
					/* translators: %s Shipping estimate location. */
					? wp_kses_post( sprintf( ' <small>' . __( 'est. for %s', 'bigbox' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] ) )
					: '';

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) :
			?>

				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="tax-rate action-list__item">
						<div id="tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>" class="action-list__item-label">
							<?php echo wp_kses_post( $tax->label . ': ' . $estimated_text ); ?>
						</div>
						<div class="action-list__item-value action-list__item-value--no-flex" labelledby="tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
							<span class="woocommerce-totals-plus">&plus; </span>
							<?php echo wp_kses_post( $tax->formatted_amount ); ?>
						</div>
					</div>
				<?php endforeach; ?>

			<?php else : ?>

				<div class="action-list__item">
					<div id="tax-total" class="tax-total action-list__item-label">
						<?php echo wp_kses_post( WC()->countries->tax_or_vat() . ': ' . $estimated_text ); ?>
					</div>
					<div class="action-list__item-value action-list__item-value--no-flex" labelledby="tax-total">
						<span class="woocommerce-totals-plus">&plus; </span>
						<?php wc_cart_totals_taxes_total_html(); ?>
					</div>
				</div>

			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<div class="action-list__item">
			<div id="total" class="order-total action-list__item-label">
				<?php esc_html_e( 'Total:', 'bigbox' ); ?>
			</div>
			<div class="action-list__item-value action-list__item-value--no-flex has-success-color" labelledby="total">
				<?php wc_cart_totals_order_total_html(); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</div>

	<?php if ( ! is_checkout() ) : ?>
	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>

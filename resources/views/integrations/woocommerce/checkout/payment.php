<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.3
 */

defined( 'ABSPATH' ) || exit;
?>

<div id="payment" class="woocommerce-checkout-payment">

	<h3><?php esc_html_e( '1. Payment Method', 'bigbox' ); ?></h3>

	<?php if ( WC()->cart->needs_payment() ) : ?>

		<ul class="wc_payment_methods payment_methods methods">

			<?php
			if ( ! empty( $available_gateways ) ) :
				foreach ( $available_gateways as $gateway ) :
					wc_get_template( 'checkout/payment-method.php', [ 'gateway' => $gateway ] );
				endforeach;
			else :
				echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'bigbox' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'bigbox' ) ) . '</li>'; // @codingStandardsIgnoreLine
			endif;
			?>

		</ul>

	<?php endif; ?>

</div>

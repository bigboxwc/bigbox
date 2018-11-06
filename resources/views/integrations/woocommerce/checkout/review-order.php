<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
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

<div class="woocommerce-checkout-review-order-table">

	<div id="bigbox-cart-review">
		<?php wc_get_template( 'checkout/cart.php' ); ?>
	</div>

	<?php woocommerce_checkout_coupon_form(); ?>

	<div id="order_review" class="card woocommerce-checkout-review-order">
		<?php wc_get_template( 'cart/cart-totals.php' ); ?>
		<?php wc_get_template( 'checkout/submit.php' ); ?>
	</div>

</div>

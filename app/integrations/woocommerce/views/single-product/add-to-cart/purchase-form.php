<?php
/**
 * Purchase form.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div id="purchase" class="woocommerce-single-product-purchase" role="complementary">
	<div class="woocommerce-purchase-form">
		<?php do_action( 'bigbox_purchase_form' ); ?>
	</div>
</div>

<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
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
	exit; // Exit if accessed directly
}

// @codingStandardsIgnoreFile

$product = wc_get_product( get_the_ID() );

if ( $price_html = $product->get_price_html() ) :
?>

<div class="woocommerce-product-price">
	<?php
	/**
	 * Allow content to be output before the price.
	 *
	 * @since 1.11.0
	 */
	do_action( 'bigbox_woocommerce_product_price_before' )
	?>

	<div class="price">
		<?php echo $price_html; ?>
	</div>

	<?php
	/**
	 * Allow content to be output after the price. By default it is the sale flash.
	 *
	 * @since 1.11.0
	 */
	do_action( 'bigbox_woocommerce_product_price_after' )
	?>
</div>

<?php
endif;

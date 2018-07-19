<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
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
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$product = wc_get_product( get_the_ID() );

$price_html = $product->get_price_html()
?>

<?php if ( $price_html ) : ?>

<div class="product__price product__meta">
	<?php
	/**
	 * Allow content to be output before the price. By default it is the sale flash.
	 *
	 * @since 1.11.0
	 */
	do_action( 'bigbox_woocommerce_loop_product_price_before' )
	?>

	<span class="price">
		<a href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', $product->get_permalink(), $product ) ); ?>">
			<?php echo $price_html; // WPCS: XSS okay. ?>
		</a>
	</span>

	<?php
	/**
	 * Allow content to be output after the price.
	 *
	 * @since 1.11.0
	 */
	do_action( 'bigbox_woocommerce_loop_product_price_after' )
	?>
</div>

<?php endif; ?>

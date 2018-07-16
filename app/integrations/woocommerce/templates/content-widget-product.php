<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
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

$product = wc_get_product( get_the_ID() );
?>
<li>
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

	<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<?php
		if ( bigbox_woocommerce_has_product_image( $product ) ) :
			echo wp_kses_post( $product->get_image() );
		endif;
		?>
		<span class="product-title"><?php echo esc_html( $product->get_name() ); ?></span>
	</a>

	<?php if ( ! empty( $show_rating ) ) : ?>
	<div class="product__meta">
		<?php echo wc_get_rating_html( $product->get_average_rating() ); // @codingStandardsIgnoreLine ?>
	</div>
	<?php endif; ?>

	<?php if ( '' !== $product->get_price_html() ) : ?>
	<span class="product__meta price">
		<?php echo wp_kses_post( $product->get_price_html() ); ?>
	</span>
	<?php endif; ?>

	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>

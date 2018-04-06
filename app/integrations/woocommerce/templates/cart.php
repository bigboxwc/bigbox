<?php
/**
 * Template Name: Cart
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

bigbox_view( 'global/header' );

while ( have_posts() ) :
	the_post();
?>

<div id="main" class="site-primary site-primary--10" role="main">
	<h1 class="page-title"><?php the_title(); ?></h1>

	<div class="woocommerce-cart-wrapper">
		<div class="woocommerce-cart-wrapper__content">
			<?php echo do_shortcode( '[woocommerce_cart]' ); ?>
		</div>

		<?php if ( ! WC()->cart->is_empty() ) : ?>
		<div class="woocommerce-cart-wrapper__purchase-form woocommerce-cart-continue">

			<div class="woocommerce-purchase-form">
				<div id="bigbox-cart-totals">
					<?php woocommerce_cart_totals(); ?>
				</div>
			</div>

			<?php if ( wc_coupons_enabled() ) : ?>
				<p class="coupons-next"><?php esc_html_e( 'Do you have a coupon or promotional code? We\'ll ask you to enter your claim code when it\'s time to pay.', 'bigbox' ); ?></p>
			<?php endif; ?>

		</div>
		<?php endif; ?>

	</div>

	<?php woocommerce_cross_sell_display(); ?>

	<div class="hentry hentry--page">
		<?php echo apply_filters( 'the_content', str_replace( '[woocommerce_cart]', '', get_post()->post_content ) ); // @codingStandardsIgnoreLine ?>
	</div>
</div>

<?php
endwhile;

bigbox_view( 'global/footer' );

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

<div id="main" class="site-primary" role="main">
	<h1 class="page-title"><?php the_title(); ?></h1>

	<div class="woocommerce-cart-wrapper">
		<div class="woocommerce-cart-wrapper__content">
			<?php echo do_shortcode( '[woocommerce_cart]' ); ?>
		</div>

		<?php if ( ! WC()->cart->is_empty() ) : ?>
		<div class="woocommerce-cart-wrapper__purchase-form woocommerce-cart-continue">
			<div id="bigbox-cart-totals" class="woocommerce-purchase-form">
				<?php woocommerce_cart_totals(); ?>
			</div>
		</div>
		<?php endif; ?>

	</div>

	<div class="hentry">
		<?php echo apply_filters( 'the_content', str_replace( '[woocommerce_cart]', '', get_post()->post_content ) ); ?>
	</div>
</div>

<?php
endwhile;

bigbox_view( 'global/footer' );

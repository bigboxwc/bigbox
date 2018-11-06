<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.1
 */

defined( 'ABSPATH' ) || exit;

$product = wc_get_product( get_the_ID() );

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form add-to-cart cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo esc_attr( absint( $product->get_id() ) ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ); // WPCS: XSS okay. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>

		<span class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'bigbox' ); ?></span>

	<?php else : ?>

		<div class="variations">

			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<div class="action-list__item">

					<div class="action-list__item-label">
						<label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
							<?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS okay. ?>:
						</label>
					</div>

					<div class="action-list__item-value">
						<div class="value">
							<?php
							wc_dropdown_variation_attribute_options(
								[
									'options'          => $options,
									'attribute'        => $attribute_name,
									'product'          => $product,
									'show_option_none' => esc_html__( 'Select an option', 'bigbox' ),
								]
							);
							?>
						</div>
					</div>

				</div>
			<?php endforeach; ?>

		</div>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap">
			<?php
				/**
				 * Before a single variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Used to output the cart button and placeholder for variation data.
				 *
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * After a single variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );

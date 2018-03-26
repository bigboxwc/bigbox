<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="action-list__item">
	<div id="package-name" class="action-list__item-label">
		<?php echo wp_kses_post( $package_name ); ?>:
	</div>
	<div>
		<a href="#" class="shipping-calculator-button"><?php echo esc_html__( 'Calculate shipping', 'bigbox' ); ?></a>
	</div>
</div>

<?php if ( 1 < count( $available_methods ) ) : ?>

	<ul id="shipping_method" class="shipping-methods">
		<?php foreach ( $available_methods as $method ) : ?>
			<li>
				<?php
					printf(
						'<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />
						<label for="shipping_method_%1$d_%2$s">%5$s</label>',
						$index, sanitize_title( $method->id ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ), wc_cart_totals_shipping_method_label( $method )
					);

					do_action( 'woocommerce_after_shipping_rate', $method, $index );
				?>
			</li>
		<?php endforeach; ?>
	</ul>

<?php
// Show single method.
elseif ( 1 === count( $available_methods ) ) :
	$method = current( $available_methods );
?>

<div class="action-list__item action-list__item--inset">
	<div class="action-list__item-label">
		<?php echo wc_cart_totals_shipping_method_label( $method ); // @codingStandardsIgnoreLine ?>
	</div>
	<div class="action-list__item-value">
		<?php echo bigbox_woocommerce_cart_shipping_method_price( $method ); // @codingStandardsIgnoreLine ?>
	</div>
</div>

<?php
	printf(
		'<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d" value="%2$s" class="shipping_method" />',
		$index,
		esc_attr( $method->id )
	);

	do_action( 'woocommerce_after_shipping_rate', $method, $index );

// No shipping.
elseif ( WC()->customer->has_calculated_shipping() ) :
	echo '<div class="shipping-note">';
	echo apply_filters( is_cart() ? 'woocommerce_cart_no_shipping_available_html' : 'woocommerce_no_shipping_available_html', wpautop( __( 'There are no shipping methods available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
	echo '</div>';

	// Unavailable.
elseif ( ! is_cart() ) :
	echo '<div class="shipping-note">';
	echo wpautop( __( 'Enter your full address to see shipping costs.', 'woocommerce' ) );
	echo '</div>';
endif;

if ( $show_package_details ) :
	echo '<div class="shipping-note">';
	echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>';
	echo '</div>';
endif;
?>

<?php if ( ! empty( $show_shipping_calculator ) ) : ?>
	<?php woocommerce_shipping_calculator(); ?>
<?php endif; ?>

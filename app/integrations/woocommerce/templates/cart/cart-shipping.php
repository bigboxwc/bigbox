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
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = __( '(update address)', 'bigbox' );
$note                     = false;
$chosen_method_object     = false;
?>

<div class="action-list__item">
	<div id="package-name" class="action-list__item-label">
		<?php echo wp_kses_post( $show_package_details ? $package_name : __( 'Shipping Method:', 'bigbox' ) ); ?>
	</div>
	<div class="action-list__item-value woocommerce-shipping-address">
		<?php
		if ( $formatted_destination ) :
			echo wp_kses( str_replace( '<br />', ', ', $formatted_destination ), [] );
		endif;
		?>
	</div>
</div>

<?php if ( $available_methods ) : ?>

	<ul id="shipping_method" class="shipping-methods">
		<?php foreach ( $available_methods as $method ) : ?>
			<li>
				<?php
					printf(
						'<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s /> <label for="shipping_method_%1$d_%2$s">%5$s</label>',
						esc_attr( $index ),
						sanitize_title( $method->id ), // @codingStandardsIgnoreLine
						esc_attr( $method->id ),
						checked( $method->id, $chosen_method, false ),
						wc_cart_totals_shipping_method_label( $method ) // @codingStandardsIgnoreLine
					);

					// Track chosen method to display price later.
				if ( $method->id === $chosen_method ) :
					$chosen_method_object = $method;
					endif;

					do_action( 'woocommerce_after_shipping_rate', $method, $index );
				?>
			</li>
		<?php endforeach; ?>

		<?php if ( ! is_checkout() && $show_shipping_calculator ) : ?>
			<li>
				<button class="shipping-calculator-button button--text"><?php echo esc_html( $calculator_text ); ?></button>
			</li>
		<?php endif; ?>
	</ul>

<?php
elseif ( ! $formatted_destination && $available_methods ) :
	$note = __( 'Enter your address to view shipping options.', 'bigbox' );
elseif ( ! is_cart() ) :
	$note = apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping methods available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'bigbox' ) );
else :
	/* translators: %s shipping destination. */
	$note = apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'bigbox' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) );
endif;

// Show note.
if ( $note ) :
?>

<p class="woocommerce-shipping-note">
	<?php echo wp_kses_post( $note ); ?>

	<?php if ( $show_shipping_calculator ) : ?>
	<button class="shipping-calculator-button button--text"><?php echo esc_html( $calculator_text ); ?></button>
	<?php endif; ?>
</p>

<?php
endif;

if ( $show_package_details ) :
	echo '<p class="woocommerce-shipping-contents">' . esc_html( $package_details ) . '</p>';
endif;

if ( $show_shipping_calculator ) :
	woocommerce_shipping_calculator( $calculator_text );
endif;
?>

<?php if ( $chosen_method_object ) : ?>

<div class="action-list__item">
	<div class="action-list__item-label">
		<?php esc_html_e( 'Shipping:', 'bigbox' ); ?>
	</div>
	<div class="action-list__item-value action-list__item-value--no-flex">
		<?php echo wp_kses_post( bigbox_woocommerce_cart_shipping_method_price( $chosen_method_object ) ); ?>
	</div>
</div>

<?php endif; ?>

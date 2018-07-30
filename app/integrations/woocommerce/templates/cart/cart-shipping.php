<?php
/**
 * Shipping Methods Display
 *
 * This file has been heavily customized and has become a bit complicated. Sorry.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Address.
$formatted_destination = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );

// Other information.
$note = false;

// Shipping methods.
$chosen_method_object = false;
$multiple_methods     = count( $available_methods ) > 1;

// Shipping calculator.
$show_shipping_calculator = ! empty( $show_shipping_calculator ) && 'yes' === get_option( 'woocommerce_enable_shipping_calc' );
$calculator_text          = __( 'Update Shipping Address', 'bigbox' );

// Generate a label for the shipping package.
$package_label = __( 'Shipping:', 'bigbox' );

if ( $show_package_details ) :
	/* translators: Shipment number index when there are multiple. e.g Shipment #1' */
	$package_label = sprintf( __( 'Shipment #%s:', 'bigbox' ), $index + 1 );
endif;
?>

<div class="woocommerce-shipping-package <?php echo esc_attr( $show_package_details ? 'woocommerce-shipping-package--of-multiple' : null ); ?>" data-index="<?php echo esc_attr( $index ); ?>">

	<div class="action-list__item">
		<div id="package-name" class="action-list__item-label">
			<?php echo wp_kses_post( $package_label ); ?>
		</div>
		<div class="action-list__item-value woocommerce-shipping-address">
			<?php
			// Show shipping calculator below method list.
			if ( $show_shipping_calculator ) :
				?>
				<button class="shipping-calculator-button button--text"><?php echo esc_html( $calculator_text ); ?></button>
			<?php endif; ?>
		</div>
	</div>

	<?php
	// Output calculator full width.
	if ( $show_shipping_calculator ) :
		woocommerce_shipping_calculator( $calculator_text );
	endif;

	// Show what is being shipped in this package after the methods if multiple.
	if ( $show_package_details ) :
		?>
		<p class="woocommerce-shipping-contents"><?php echo esc_html( $package_details ); ?></p>
	<?php endif; ?>

	<?php
	// Show shipping methods. Will be hidden with CSS if only one is available.
	if ( $available_methods ) :
		?>

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
		</ul>

		<?php
		// No address available.
	elseif ( ! $formatted_destination && $available_methods ) :
		$note = __( 'Enter your address to view shipping options.', 'bigbox' );
		// Nothing enabled in admin.
	elseif ( ! is_cart() ) :
		$note = apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping methods available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'bigbox' ) );
		// Nothing found for address.
	else :
		/* translators: %s shipping destination. */
		$note = apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'bigbox' ) . ' ' . $formatted_destination ) );
	endif;
	?>

	<?php
	// Show note.
	if ( $note ) :
		?>
		<p class="woocommerce-shipping-note"><?php echo wp_kses_post( $note ); ?></p>
	<?php endif; ?>

	<?php
	// Show the price of the chosen method.
	if ( $chosen_method_object ) :
		?>

		<div class="action-list__item">
			<div class="action-list__item-label"></div>
			<div class="action-list__item-value action-list__item-value--no-flex">
				<span class="woocommerce-totals-plus">&plus; </span>
				<?php echo bigbox_woocommerce_cart_shipping_method_price( $chosen_method_object ); // WPCS: XSS okay. ?>
			</div>
		</div>

		<?php
		// Show what is being shipped in this package after the label if only one method.
		if ( $show_package_details && ! $multiple_methods ) :
			?>
			<p class="woocommerce-shipping-contents"><?php echo esc_html( $package_details ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

</div>

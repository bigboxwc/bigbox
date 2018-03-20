<?php
/**
 * Add to Cart quantity.
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

/* translators: %s: Quantity. */
$labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'bigbox' ), strip_tags( $args['product_name'] ) ) : '';
?>

<div id="add-to-cart-quantity">
	<input
		type="number"
		id="<?php echo esc_attr( $input_id ); ?>"
		class="input-text qty text"
		step="<?php echo esc_attr( $step ); ?>"
		min="<?php echo esc_attr( $min_value ); ?>"
		max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
		name="<?php echo esc_attr( $input_name ); ?>"
		value="<?php echo esc_attr( $input_value ); ?>"
		title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'bigbox' ); ?>"
		size="4"
		pattern="<?php echo esc_attr( $pattern ); ?>"
		inputmode="<?php echo esc_attr( $inputmode ); ?>"
		aria-labelledby="<?php echo esc_attr( $labelledby ); ?>"
	/>
</div>

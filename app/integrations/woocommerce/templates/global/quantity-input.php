<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_singular( 'product' ) ) :
?>

<div class="add-to-cart__action">

	<div class="add-to-cart__action-label">
		<label for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'bigbox' ); ?>:</label>
	</div>

	<div class="add-to-cart__action-value">
	<?php
	wc_get_template(
		'single-product/add-to-cart/quantity.php', [
			'min_value'   => $min_value,
			'max_value'   => $max_value,
			'input_id'    => $input_id,
			'input_name'  => $input_name,
			'input_value' => $input_value,
			'inputmode'   => $inputmode,
			'pattern'     => $pattern,
			'args'        => $args,
			'step'        => $step,
		]
	);
	?>
	</div>
</div>

<?php
	return;
endif;

if ( $max_value && $min_value === $max_value ) :
?>

<div class="quantity hidden">
	<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
</div>

<?php
else :
	/* translators: %s: Quantity. */
	$labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'bigbox' ), strip_tags( $args['product_name'] ) ) : '';
?>

<div class="quantity">
	<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'bigbox' ); ?></label>

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
		aria-labelledby="<?php echo esc_attr( $labelledby ); ?>" />
</div>

<?php
endif;

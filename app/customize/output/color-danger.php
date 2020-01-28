<?php
/**
 * Config for danger color output.
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

$danger = bigbox_get_theme_color( 'danger' );
$rgba10 = bigbox_hex_to_rgba( $danger, 0.10 );
$rgba30 = bigbox_hex_to_rgba( $danger, 0.30 );
$rgba50 = bigbox_hex_to_rgba( $danger, 0.50 );

return [
	// Solid color.
	[
		'selectors'    => [
			'.woocommerce-purchase-form .out-of-stock',
			'label .required',
			'.order-status--failed',
			'.order-status--cancelled',
		],
		'declarations' => [
			'color' => esc_attr( $danger ),
		],
	],

	// @mixin card--error.
	[
		'selectors'    => [
			'.card.card--color-danger',
			'.woocommerce-error',
			'.wcpv-registration-message.wcpv-shortcode-registration-form-errors',
		],
		'declarations' => [
			'color'        => esc_attr( $danger ),
			'border-color' => esc_attr( $rgba50 ),
			'box-shadow'   => esc_attr( "inset {$rgba10} 0 0 0 3px, {$rgba30} 0 1px 2px" ),
			'font-weight'  => esc_attr( bigbox_get_theme_font_weight( 'bold' ) ),
		],
	],
	// @mixin button--color-danger
	[
		'selectors'    => [
			'.button--color-danger',
			'.woocommerce-orders-table__cell-order-actions .woocommerce-button.cancel',
		],
		'declarations' => [
			'background-color' => esc_attr( $danger ),
		],
	],
];

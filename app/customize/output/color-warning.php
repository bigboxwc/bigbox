<?php
/**
 * Config for warning color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$warning = bigbox_get_theme_color( 'warning' );

return [
	// Solid background-color.
	[
		'selectors'    => [
			'.woocommerce-store-notice',
			'.button--warning',
		],
		'declarations' => [
			'background-color' => esc_attr( $warning ),
		],
	],
	// Semi-transparent border-color.
	[
		'selectors'    => [
			'.woocommerce-order-notes',
		],
		'declarations' => [
			'border-color' => esc_attr( bigbox_hex_to_rgba( $warning, 0.30 ) ),
		],
	],
	// Solid color.
	[
		'selectors'    => [
			'.woocommerce-remove-coupon',
			'.order-status--on-hold',
			'.order-status--refunded',
			'.woocommerce-order-notes .widget-title',
		],
		'declarations' => [
			'color' => esc_attr( $warning ),
		],
	],
];

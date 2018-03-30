<?php
/**
 * Config for gray-700 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$gray700 = bigbox_get_theme_color( 'gray-700' );

return [
	// Solid color
	[
		'selectors'    => [
			'.select2-container--default .select2-selection--single .select2-selection__rendered',
		],
		'declarations' => [
			'color' => esc_attr( $gray700 ),
		],
	],
	// Solid border-color
	[
		'selectors'    => [
			'.woocommerce-product-gallery__trigger:before',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray700 ),
		],
	],
	// Solid background-color
	[
		'selectors'    => [
			'.woocommerce-product-gallery__trigger:after',
		],
		'declarations' => [
			'background-color' => esc_attr( $gray700 ),
		],
	],
];

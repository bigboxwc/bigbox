<?php
/**
 * Config for gray-100 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$gray100 = bigbox_get_theme_color( 'gray-100' );

return [
	// Solid background-color
	[
		'selectors'    => [
			'table tbody tr:nth-child(even) th',
			'table tbody tr:nth-child(even) td',
			'.facetwp-facet .facetwp-slider',
			'.footer-copyright',
			'.navbar-mobile__close',
		],
		'declarations' => [
			'background-color' => esc_attr( $gray100 ),
		],
	],
	// Solid border-color
	[
		'selectors'    => [
			'.single_variation_wrap',
			'.woocommerce-variation.woocommerce-variation--loaded',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray100 ),
		],
	],
];

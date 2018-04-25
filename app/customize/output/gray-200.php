<?php
/**
 * Config for gray-200 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$gray200 = bigbox_get_theme_color( 'gray-200' );

return [
	// Solid border-color
	[
		'selectors'    => [
			'table td',
			'table th',
			'.blog-post',
			'.navbar-mobile__close',
			'.page-title',
			'.product__inner',
			'.widget',
			'.woocommerce-MyAccount-navigation',
			'.woocommerce-single-product-data__section',
			'.footer-nav',
			'.wp-block-separator',
			'.comment',
			'.comments',
			'.single_variation_wrap',
			'.woocommerce-variation--loaded .woocommerce-variation',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray200 ),
		],
	],
	// Solid box-shadow
	[
		'selectors'    => [
			'table',
		],
		'declarations' => [
			'box-shadow' => esc_attr( "{$gray200} 0 0 0 1px" ),
		],
	],
];

<?php
/**
 * Config for dark color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$dark = bigbox_get_theme_color( 'dark' );

return [
	// Solid color
	[
		'selectors'    => [
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'.breadcrumbs a',
			'.woocommerce-breadcrumb a',
			'.woocommerce-pagination .active',
			'.woocommerce-pagination .current',
			'.single-product .product_title',
		],
		'declarations' => [
			'color' => esc_attr( $dark ),
		],
	],
	// Solid border-color
	[
		'selectors'    => [
			'.wp-block-quote:not(.is-large)',
		],
		'declarations' => [
			'border-color' => esc_attr( $dark ),
		],
	],
];

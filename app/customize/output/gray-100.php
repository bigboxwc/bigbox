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
			'.breadcrumbs',
			'.woocommerce-breadcrumb',
			'.woocommerce-pagination',
			'.facetwp-pager',
			'.navbar-search__category select',
			'.woocommerce-page ul.products-categories li.product.product-category',
			'.woocommerce ul.products-categories li.product.product-category',
		],
		'declarations' => [
			'background-color' => esc_attr( $gray100 ),
		],
	],
	// Solid border-color
	[
		'selectors'    => [
			'.footer-nav',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray100 ),
		],
	],
];

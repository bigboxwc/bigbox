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
	// Solid border-color.
	[
		'selectors'    => [
			'.blog-post',
			'.navbar-mobile__close',
			'.page-title',
			'.product__inner',
			'.widget',
			'.woocommerce-MyAccount-navigation:after',
			'.woocommerce-single-product-data__section',
			'.footer-nav',
			'.wp-block-separator',
			'.comment',
			'.comments',
			'.single_variation_wrap',
			'.woocommerce-variation--loaded .woocommerce-variation',
			'.woocommere-product-brand a',
			'.woocommerce-privacy-policy-text',
			'.wc-social-login',
			'.woocommerce-OrderUpdate',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray200 ),
		],
	],
	// Solid background-color.
	[
		'selectors'    => [
			'.woocommerce-page ul.products-categories li.product.product-category',
			'.woocommerce ul.products-categories li.product.product-category',
			'.woocommerce-page ul.products-categories:after',
			'.woocommerce ul.products-categories:after',

			'.widget_price_filter .price_slider_wrapper .ui-widget-content',
			'.facetwp-facet .facetwp-slider',

			// select2.
			'.select2-container--default .select2-results__option[aria-selected=true]',
			'.select2-container--default .select2-results__option[data-selected=true]',
		],
		'declarations' => [
			'background-color' => esc_attr( $gray200 ),
		],
	],
];

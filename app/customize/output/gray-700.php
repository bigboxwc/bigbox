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
	// Solid color.
	[
		'selectors'    => [
			'body',
			'[type="email"]',
			'[type="search"]',
			'[type="tel"]',
			'[type="url"]',
			'[type="password"]',
			'[type="text"]',
			'textarea',
			'select',
			'.navbar-menu--primary .sub-menu a',
			'.navbar-menu--secondary .sub-menu a',
			'.navbar-menu--primary .sub-menu .menu-item > a:before',
			'.navbar-menu--primary .sub-menu .menu-item i.bigbox-icon',
			'.breadcrumbs a',
			'.woocommerce-breadcrumb a',
			'.button--text',

			// select2.
			'.select2-container--default .select2-results__option[aria-selected=true]',
			'.select2-container--default .select2-results__option[data-selected=true]',
			'.select2-container--default .select2-selection--single .select2-selection__rendered',
		],
		'declarations' => [
			'color' => esc_attr( $gray700 ),
		],
	],
	// Solid border-color.
	[
		'selectors'    => [
			'.woocommerce-product-gallery__trigger:before',
			'.offcanvas-drawer__close:before',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray700 ),
		],
	],
	// Solid background-color.
	[
		'selectors'    => [
			'.woocommerce-product-gallery__trigger:after',
			'i.bigbox-icon',
		],
		'declarations' => [
			'background-color' => esc_attr( $gray700 ),
		],
	],
	// Solid fill.
	[
		'selectors'    => [
			'.bigbox-icon',
			'.woocommerce-product-gallery .flex-direction-nav svg',
		],
		'declarations' => [
			'fill' => esc_attr( $gray700 ),
		],
	],
];

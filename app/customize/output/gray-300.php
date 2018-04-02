<?php
/**
 * Config for gray-300 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$gray300 = bigbox_get_theme_color( 'gray-300' );

return [
	// Solid border-color
	[
		'selectors'    => [
			'.navbar-mobile .sub-menu',
			'.wc-credit-card-form #stripe-card-element',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray300 ),
		],
	],

	// @mixin form--input
	[
		'selectors'    => [
			'textarea',
			'[type="email"]',
			'[type="search"]',
			'[type="tel"]',
			'[type="url"]',
			'[type="password"]',
			'[type="text"]',
			'.navbar-search__submit [type="submit"]',
			'.woocommerce .input-text',
			'.select2-container--default .select2-selection--single',
			'.select2-container--default:focus .select2-selection--single',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray300 ),
		],
	],
];

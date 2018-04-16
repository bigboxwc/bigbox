<?php
/**
 * Config for gray-600 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$gray600 = bigbox_get_theme_color( 'gray-600' );

return [
	// Solid color
	[
		'selectors'    => [
			'.product__stock',
		],
		'declarations' => [
			'color' => esc_attr( $gray600 ),
		],
	],

	// Solid border-top-color
	[
		'selectors'    => [
			'.navbar-search__category:before',
		],
		'declarations' => [
			'border-top-color' => esc_attr( $gray600 ),
		],
	],
];

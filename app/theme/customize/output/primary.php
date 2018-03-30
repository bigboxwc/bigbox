<?php
/**
 * Config for primary color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$primary = bigbox_get_theme_color( 'primary' );
$rgba25  = bigbox_hex_to_rgba( $primary, 0.25 );

return [
	// Solid background-color
	[
		'selectors'    => [
			'.navbar',
			'.facetwp-facet .facetwp-slider .noUi-connect',
			'.select2-container--default .select2-results__option--highlighted[data-selected]',
		],
		'declarations' => [
			'background-color' => esc_attr( $primary ),
		]
	],
	// Solid fill
	[
		'selectors'    => [
			'.navbar-search__submit svg',
		],
		'declarations' => [
			'fill' => esc_attr( $primary ),
		]
	],
	// Solid border-color
	[
		'selectors'    => [
			'.woocommerce-MyAccount-navigation-link.is-active a',
		],
		'declarations' => [
			'border-color' => esc_attr( $primary ),
		]
	],
	// RGBA 0.25 border-color
	[
		'selectors'    => [
			'.woocommerce-loop-category__title',
		],
		'declarations' => [
			'border-color' => esc_attr( $rgba25 ),
		]
	],
];

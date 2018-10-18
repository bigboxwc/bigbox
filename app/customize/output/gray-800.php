<?php
/**
 * Config for gray-800 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$gray800 = bigbox_get_theme_color( 'gray-800' );
$default = bigbox_get_theme_default_color( 'gray-800' );

if ( $gray800 === $default ) {
	return [];
}

return [
	// Solid color.
	[
		'selectors'    => [
			'a',
			'mark',
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'.action-list__item-value',

			'.woocommerce-terms-and-conditions-text',
		],
		'declarations' => [
			'color' => esc_attr( $gray800 ),
		],
	],

	// Solid border-left-color.
	[
		'selectors'    => [
			'.navbar--mobile .menu-item-has-children > a:after',
		],
		'declarations' => [
			'border-left-color' => esc_attr( $gray800 ),
		],
	],
];

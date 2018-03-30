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

$gray800 = bigbox_get_theme_color( 'gray-800' );

return [
	// Solid color
	[
		'selectors'    => [
			'a:hover',
		],
		'declarations' => [
			'color' => esc_attr( $gray800 ),
		],
	],
];

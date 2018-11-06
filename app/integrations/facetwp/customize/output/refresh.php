<?php
/**
 * Append background color for FacetWP refresh.
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

return [
	[
		'selectors'    => [
			'.facetwp-template__loading',
		],
		'declarations' => [
			'background-color' => esc_attr( bigbox_hex_to_rgba( '#' . get_background_color(), 0.75 ) ),
		],
	],
];

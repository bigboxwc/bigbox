<?php
/**
 * Config for Gray 200 color output.
 *
 * @since 2.3.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$gray200 = bigbox_get_theme_color( 'gray-200' );
$default = bigbox_get_theme_default_color( 'gray-200' );

if ( $gray200 === $default ) {
	return [];
}

return [
	[
		'selectors'    => [
			'.facetwp-facet.facetwp-type-alpha',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray200 ),
		],
	],
];

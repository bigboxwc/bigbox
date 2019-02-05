<?php
/**
 * Primary color.
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

$primary = bigbox_get_theme_color( 'primary' );

return [
	[
		'selectors'    => [
			'.facetwp-facet.facetwp-type-alpha .facetwp-alpha.selected',
		],
		'declarations' => [
			'color' => esc_attr( $primary ),
		],
	],
];

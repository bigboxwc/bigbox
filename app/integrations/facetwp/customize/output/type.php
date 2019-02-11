<?php
/**
 * Config for type output.
 *
 * @since 3.1.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

$weight_base = bigbox_get_theme_font_weight( 'base' );

if ( 'regular' === $weight_base ) {
	$weight_base = 'normal';
}

return [
	// Base weight.
	[
		'selectors'    => [
			'.facetwp-checkbox label',
			'.facetwp-radio label',
		],
		'declarations' => [
			'font-weight' => $weight_base,
		],
	],
];

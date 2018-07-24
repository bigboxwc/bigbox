<?php
/**
 * Config for info color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$info = bigbox_get_theme_color( 'information' );

return [
	// Solid background-color.
	[
		'selectors'    => [
			'.button--information',
		],
		'declarations' => [
			'background-color' => esc_attr( $info ),
		],
	],
	// Solid color.
	[
		'selectors'    => [
			'.order-status--processing',
			'.order-status--pending',
		],
		'declarations' => [
			'color' => esc_attr( $info ),
		],
	],
];

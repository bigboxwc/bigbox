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

$info = bigbox_get_theme_color( 'info' );

return [
	// Solid background-color.
	[
		'selectors'    => [
			'.button--info',
		],
		'declarations' => [
			'background-color' => esc_attr( $info ),
		],
	],
];

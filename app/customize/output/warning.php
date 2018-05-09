<?php
/**
 * Config for warning color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$warning = bigbox_get_theme_color( 'warning' );

return [
	// Solid background-color.
	[
		'selectors'    => [
			'.woocommerce-store-notice',
			'.button--warning',
		],
		'declarations' => [
			'background-color' => esc_attr( $warning ),
		],
	],
];

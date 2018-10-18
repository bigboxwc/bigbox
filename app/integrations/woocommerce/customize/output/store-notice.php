<?php
/**
 * Append store notice colors.
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

$text = get_theme_mod( 'demo-store-notice-color', '#565656' );
$bg   = get_theme_mod( 'demo-store-notice-color-background', '#e8bc55' );

return [
	[
		'selectors'    => [
			'.woocommerce-store-notice',
		],
		'declarations' => [
			'color'            => esc_attr( $text ),
			'background-color' => esc_attr( $bg ),
		],
	],
	[
		'selectors'    => [
			'.woocommerce-store-notice a',
		],
		'declarations' => [
			'color' => esc_attr( $text ),
		],
	],
];

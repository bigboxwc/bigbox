<?php
/**
 * Config for gray-500 color output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$gray500 = bigbox_get_theme_color( 'gray-500' );

return [
	// Solid color
	[
		'selectors'    => [
			'.star-rating__count',
			'.woocommerce-review-link',
			'.coupons-next',
			'.wc_payment_method label',
		],
		'declarations' => [
			'color' => esc_attr( $gray500 ),
		],
	],
	// Solid background-color
	[
		'selectors'    => [
			'.navbar-menu__items-secondary .sub-menu .menu-item-has-children > a:after',
		],
		'declarations' => [
			'background-color' => esc_attr( $gray500 ),
		],
	],
];

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
	// Solid color.
	[
		'selectors'    => [
			'.star-rating__count',
			'.woocommerce-review-link',
			'.coupons-next',
			'.wc_payment_method label',
			'.woocommerce-products-header .term-description',
		],
		'declarations' => [
			'color' => esc_attr( $gray500 ),
		],
	],
];

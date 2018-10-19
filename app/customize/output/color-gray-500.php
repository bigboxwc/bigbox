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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$gray500 = bigbox_get_theme_color( 'gray-500' );

return [
	// Solid color.
	[
		'selectors'    => [
			'.star-rating__count',
			'.woocommerce-review-link',
			'.coupons-next',
			'.wc_payment_method label[for^="payment_method"]',
			'.woocommerce .input-text + span',
			'.woocommerce-OrderUpdate-meta',
			'.woocommerce-totals-plus',
			'.tax_label',
			'.action-list__item-label small',
		],
		'declarations' => [
			'color' => esc_attr( $gray500 ),
		],
	],
];

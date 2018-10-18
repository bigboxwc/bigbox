<?php
/**
 * Config for type output.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

$family = bigbox_get_theme_font_family();
$size   = get_theme_mod( 'type-font-size', 1 );

$weight_base = bigbox_get_theme_font_weight( 'base' );
$weight_bold = bigbox_get_theme_font_weight( 'bold' );

if ( 'regular' === $weight_base ) {
	$weight_base = 'normal';
}

// Force a browser-rendered bold weight.
if ( 'regular' === $weight_bold ) {
	$weight_bold = 'bold';
}

// Separate out so we can add family only if needed.
$base = [
	'selectors'    => [
		'body',
		'button',

		'[type="email"]',
		'[type="search"]',
		'[type="tel"]',
		'[type="url"]',
		'[type="password"]',
		'[type="text"]',
		'textarea',
		'select',

		// .form-input
		'.woocommerce .input-text',
		'#stripe-card-element',
		'#stripe-exp-element',
		'#stripe-cvc-element',

		'.button',
		'.navbar-menu--primary .sub-menu li',
		'.navbar-menu--secondary .sub-menu li',
		'.widget-title',
		'#place_order',

		'.wc-bookings-booking-form',
		'.wc-bookings-booking-form .ui-widget',
	],
	'declarations' => [
		'font-weight' => esc_attr( $weight_base ),
		'font-size'   => esc_attr( "{$size}em" ),
	],
];

if ( 'default' !== $family ) {
	$fallback = get_theme_mod( 'type-font-family-fallback', 'sans-serif' );

	$base['declarations']['font-family'] = '"' . esc_attr( $family ) . '", ' . esc_attr( $fallback );
}

return [
	$base,

	// Base weight.
	[
		'selectors'    => [
			'.cart_totals #shipping_method label',
			'.woocommerce-form__label-for-checkbox',
			'.action-list__item-label .amount',
			'.action-list__item-label small',
		],
		'declarations' => [
			'font-weight' => $weight_base,
		],
	],
	// Bold weight.
	[
		'selectors'    => [
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'strong',
			'label',
			'mark',
			'table tfoot td',
			'.offcanvas-drawer__close',
			'.woocommerce table.shop_table_responsive tr td::before',
			'.woocommerce-page table.shop_table_responsive tr td::before',
			'.product__sale',
			'.site-title',
			'.action-list__item-label',
			'.widget-title',
			'.product-title',
			'.woocommerce-terms-and-conditions-text',
			'.product-category-more__inner',
			'.woocommerce-loop-category__title',
			'.wc-layered-nav-term.chosen',
			'.woocommerce-mini-cart-item a',
			'.woocommerce-MyAccount-navigation-link a',
			'.shop-filters__mobile-toggle-link',
			'.wp-block-cover-image-text',
			'.product span.posted_in',

			'.wcpv-sold-by-single',
			'.wcpv-sold-by-loop',
			'.wcpv-sold-by-order-details',
		],
		'declarations' => [
			'font-weight' => esc_attr( $weight_bold ),
		],
	],
];

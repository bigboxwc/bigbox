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

$family   = bigbox_get_theme_font_family();
$fallback = get_theme_mod( 'type-font-family-fallback', 'sans-serif' );
$size     = get_theme_mod( 'type-font-size', 1 );

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
	],
	'declarations' => [
		'font-weight' => esc_attr( $weight_base ),
		'font-size'   => esc_attr( "{$size}em" ),
	],
];

// Only add family if not using system default.
if ( 'default' !== $family ) {
	$base['declarations']['font-family'] = sprintf( '"%1$s", %2$s', esc_attr( $family ), esc_attr( $fallback ) );
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
			'.site-title',
			'.price ins',
			'.action-list__item-label',
			'.widget-title',
			'.product-title',
			'.wc-block-grid .wc-block-grid__products .wc-block-grid__product .wc-block-grid__product-title',
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

<?php
/**
 * Selector helper functions.
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

/**
 * List of base button selectors.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_customize_get_button_selectors() {
  return [
    '.button',
    'button',
    '.widget_layered_nav_filters a',
    '.woocommerce-notice-list__item .woocommerce-Button',
    '.woocommerce-notice-list__item .wc-forward',
    '.single_add_to_cart_button',
    '.checkout-button',
    '#place_order',
    '.woocommerce-Address-title .edit',
    '.widget_shopping_cart_content .checkout',
    '#wl-wrapper.wl-button-wrap .wl-add-to-single',
    '.facetwp-facet .facetwp-submit',
    '.facetwp-facet .facetwp-autocomplete-update',
    '.facetwp-facet .facetwp-slider-reset',
    '.comment-form [type="submit"]',
    '.wp-block-button .wp-block-button__link',
  ];
}

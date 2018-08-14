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
 * Add an element state to a list of selectors.
 *
 * @since 1.13.0
 *
 * @param array  $selectors List of selectors.
 * @param string $state State to append.
 * @return array
 */
function bigbox_customize_add_state_to_selectors( $selectors, $state ) {
	return array_map(
		function( $selector ) use ( $state ) {
			return sprintf( '%1$s:%2$s', $selector, $state );
		},
		$selectors
	);
}

/**
 * List of base button selectors.
 *
 * @since 1.13.0
 *
 * @return array
 */
function bigbox_customize_get_button_selectors() {
	return [
		'.button:not(.button--text)',
		'button:not(.button--text)',
		'.widget_layered_nav_filters a',
		'.woocommerce-notice-list__item .woocommerce-Button',
		'.woocommerce-notice-list__item .wc-forward',
		'.single_add_to_cart_button',
		'.woocommerce-Address-title .edit',
		'.widget_shopping_cart_content .checkout',
		'#wl-wrapper.wl-button-wrap .wl-add-to-single',
		'.facetwp-facet .facetwp-submit',
		'.facetwp-facet .facetwp-autocomplete-update',
		'.facetwp-facet .facetwp-slider-reset',
		'.comment-form [type="submit"]',
	];
}

/**
 * List of base success button selectors.
 *
 * @since 1.13.0
 *
 * @return array
 */
function bigbox_customize_get_button_success_selectors() {
	return [
		'.button--color-success',
		'.checkout-button',
		'#place_order',
		'.single_add_to_cart_button',
		'.woocommerce-form-coupon [name="apply_coupon"]',
		'.woocommerce-notice-list__item .woocommerce-Button',
		'.woocommerce-notice-list__item .wc-forward',
	];
}

/**
 * List of base form input selectors.
 *
 * @since 1.13.0
 *
 * @return array
 */
function bigbox_customize_get_form_input_selectors() {
	return [
		'textarea',
		'[type="email"]',
		'[type="search"]',
		'[type="tel"]',
		'[type="url"]',
		'[type="password"]',
		'[type="text"]',

		'.navbar-search__submit [type="submit"]',

		'.woocommerce .input-text',

		'.select2-container--default .select2-selection--single',
		'.select2-container--default:focus .select2-selection--single',
	];
}

<?php
/**
 * Config for gray-400 color output.
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

$gray400 = bigbox_get_theme_color( 'gray-400' );

return [
	// Solid border-color.
	[
		'selectors'    => [
			'.wc_payment_method [type="radio"] label:before',
			'ul.brands_index li a',
			'ul.brands_index li span',
			'.product__has-variations a:hover',
			'.widget_layered_nav_filters a:hover',
		],
		'declarations' => [
			'border-color' => esc_attr( $gray400 ),
		],
	],

	// Solid border-color.
	[
		'selectors'    => [
			'.navbar-menu__items-primary .sub-menu .menu-item-has-children > a:after',
			'.navbar-menu__items-secondary .sub-menu .menu-item-has-children > a:after',
			'.navbar--mobile .menu-item-has-children:after',
		],
		'declarations' => [
			'border-left-color' => esc_attr( $gray400 ),
		],
	],
	[
		'selectors'    => [
			'.rtl .navbar-menu__items-primary .sub-menu .menu-item-has-children > a:after',
			'.rtl .navbar-menu__items-secondary .sub-menu .menu-item-has-children > a:after',
			'.rtl .navbar--mobile .menu-item-has-children:after',
			'.navbar-menu__items-primary .sub-menu .menu-item-has-children > a:after',
			'.navbar-menu__items-secondary .sub-menu .menu-item-has-children > a:after',
		],
		'declarations' => [
			'border-right-color' => esc_attr( $gray400 ),
			'border-left-color'  => 'transparent',
		],
	],

	// @mixin form--input
	[
		'selectors'    => bigbox_customize_add_state_to_selectors( bigbox_customize_get_form_input_selectors(), 'focus' ),
		'declarations' => [
			'border-color' => esc_attr( $gray400 ),
		],
	],
];

<?php
/**
 * Build CSS for editor iframe.
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

$css = new \BigBox\Customize\Build_Inline_CSS();

$gray700 = bigbox_get_theme_color( 'gray-700' );
$gray800 = bigbox_get_theme_color( 'gray-800' );

$family      = bigbox_get_theme_font_family();
$weight_base = bigbox_get_theme_font_weight( 'base' );
$weight_bold = bigbox_get_theme_font_weight( 'bold' );
$size        = get_theme_mod( 'type-font-size', 1 );

$css->add( [
	'selectors'    => [
		'html .mce-content-body',
	],
	'declarations' => [
		'color' => esc_attr( $gray700 ),
	],
] );

$css->add( [
	'selectors'    => [
		'html .mce-content-body a',
	],
	'declarations' => [
		'color' => esc_attr( $gray800 ),
	],
] );

$type = [
	'font-weight' => $weight_base,
	'font-size'   => "{$size}em",
];

if ( $family ) {
	$type['font-family'] = $family;
}

$css->add( [
	'selectors'    => [
		'html .mce-content-body',
	],
	'declarations' => $type,
] );

$css->add( [
	'selectors'    => [
		'html .mce-content-body strong',
	],
	'declarations' => [
		'font-weight' => $weight_bold,
	],
] );

return $css->build();

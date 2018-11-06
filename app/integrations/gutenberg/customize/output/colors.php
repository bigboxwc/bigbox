<?php
/**
 * Config for Gutenberg color output.
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

$colors = bigbox_get_theme_colors();
$output = [];

foreach ( $colors as $color => $data ) {
	$theme_color = bigbox_get_theme_color( $color );
	$default     = bigbox_get_theme_default_color( $color );

	if ( $theme_color === $default ) {
		continue;
	}

	$output[] = [
		'selectors'    => [
			".has-{$color}-background-color",
			".wp-block-button .wp-block-button__link.has-{$color}-background-color",
		],
		'declarations' => [
			'background-color' => esc_attr( $theme_color ),
		],
	];

	$output[] = [
		'selectors'    => [
			".has-{$color}-color",
			".has-{$color}-color a",
			".wp-block-button .wp-block-button__link.has-{$color}-color",
		],
		'declarations' => [
			'color' => esc_attr( $theme_color ),
		],
	];

	$output[] = [
		'selectors'    => [
			".wp-block-button.is-style-outline .wp-block-button__link.has-{$color}-color",
			".wp-block-button.is-style-outline .wp-block-button__link.has-{$color}-color:hover",
		],
		'declarations' => [
			'color'        => esc_attr( $theme_color ),
			'border-color' => esc_attr( $theme_color ),
		],
	];
}

return $output;

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

$colors = bigbox_get_theme_colors();
$output = [];

foreach ( $colors as $color => $data ) {
	$output[] = [
		'selectors'    => [
			".has-{$color}-background-color",
			".wp-block-button__link:not(.has-background).has-{$color}-background-color",
			".wp-block-button__link:not(.has-background).has-{$color}-background-color:active",
			".wp-block-button__link:not(.has-background).has-{$color}-background-color:focus",
			".wp-block-button__link:not(.has-background).has-{$color}-background-color:hover",
		],
		'declarations' => [
			'background-color' => esc_attr( bigbox_get_theme_color( $color ) ),
		],
	];

	$output[] = [
		'selectors'    => [
			".has-{$color}-color",
			".has-{$color}-color a",
			".wp-block-button .wp-block-button__link:not(.has-background).has-{$color}-color",
		],
		'declarations' => [
			'color' => esc_attr( bigbox_get_theme_color( $color ) ),
		],
	];
}

return $output;

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
		],
		'declarations' => [
			'background-color' => esc_attr( bigbox_get_theme_color( $color ) ),
		],
	];

	$output[] = [
		'selectors'    => [
			".has-{$color}-color",
			".has-{$color}-color a",
		],
		'declarations' => [
			'color' => esc_attr( bigbox_get_theme_color( $color ) ),
		],
	];
}

return $output;

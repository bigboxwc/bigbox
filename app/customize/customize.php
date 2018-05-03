<?php
/**
 * WordPress customize enhancements.
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

// Colors and Type helpers.
require_once get_template_directory() . '/app/customize/color-functions.php';
require_once get_template_directory() . '/app/customize/type-functions.php';

// Controls.
require_once get_template_directory() . '/app/customize/controls.php';

// Handle live preview.
require_once get_template_directory() . '/app/customize/preview.php';

/**
 * Build inline CSS.
 *
 * @since 1.0.0
 */
function bigbox_customize_css() {
	$css      = new \BigBox\Customize\Build_Inline_CSS();
	$colors   = bigbox_get_theme_colors();
	$controls = array_merge( [ 'type' => [] ], $colors['scheme'], $colors['grays'] );

	foreach ( $controls as $key => $data ) {
		$file = get_template_directory() . '/app/customize/output/' . $key . '.php';

		if ( ! file_exists( $file ) ) {
			continue;
		}

		$config = apply_filters(
			'bigbox_customize_css_' . $key,
			include $file
		);

		foreach ( $config as $data ) {
			$css->add( $data );
		}
	}

	return $css->build();
}

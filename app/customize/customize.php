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

// Modify core controls.
require_once get_template_directory() . '/app/customize/controls/wordpress.php';

// Colors and Type
require_once get_template_directory() . '/app/customize/colors.php';
require_once get_template_directory() . '/app/customize/type.php';

// Handle live preview.
require_once get_template_directory() . '/app/customize/preview.php';

/**
 * Build inline CSS.
 *
 * @since 1.0.0
 */
function bigbox_customize_css() {
	$css = new \BigBox\Customize\Build_Inline_CSS();

	$colors = bigbox_get_theme_colors();
	$colors = array_merge( $colors['scheme'], $colors['grays'] );

	foreach ( $colors as $key => $data ) {
		$file = get_template_directory() . '/app/customize/output/' . $key . '.php';

		if ( ! file_exists( $file ) ) {
			continue;
		}

		$config = include $file;

		foreach ( $config as $data ) {
			$css->add( $data );
		}
	}

	return $css->build();
}

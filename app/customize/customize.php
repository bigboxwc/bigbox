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
require_once get_template_directory() . '/app/customize/selector-functions.php';

// Controls.
require_once get_template_directory() . '/app/customize/controls.php';

// Handle live preview.
require_once get_template_directory() . '/app/customize/preview.php';

/**
 * Build inline CSS.
 *
 * @since 1.0.0
 */
function bigbox_customize_inline_css() {
	$css = new \BigBox\Customize\Build_Inline_CSS();

	/**
	 * Output custom colors.
	 *
	 * Only outputs colors that have changed from their defaults.
	 */
	$colors = array_keys( bigbox_get_theme_colors() );

	foreach ( $colors as $key ) {
		$file = get_template_directory() . '/app/customize/output/color-' . $key . '.php';

		if ( ! file_exists( $file ) ) {
			continue;
		}

		// Don't output non-customized colors.
		$color   = bigbox_get_theme_color( $key );
		$default = bigbox_get_theme_default_color( $key );
		$config  = include $file;

		bigbox_customize_add_inline_css_by_config( $css, $key, $config );
	}

	/**
	 * Sub in additional output items.
	 *
	 * Separated from colors because they aren't easily as checked against default values.
	 */
	$extras = [
		'type' => include get_template_directory() . '/app/customize/output/type.php',
	];

	/**
	 * Filters extra configurations to be loaded.
	 *
	 * Use this to include straight configuration files. If logic is needed to
	 * determine if items should be loaded, use the `bigbox_customize_inline_css`
	 * hook below.
	 *
	 * @since 1.16.0
	 *
	 * @param array $extras
	 */
	$extras = apply_filters( 'bigbox_customize_inline_css_configs', $extras );

	foreach ( $extras as $key => $config ) {
		bigbox_customize_add_inline_css_by_config( $css, $key, $config );
	}

	/**
	 * Allow appending more CSS to the inline output.
	 *
	 * @since 1.0.0
	 *
	 * @param BigBox\Customize\Build_Inline_CSS $css CSS object to handle building inline output.
	 */
	do_action( 'bigbox_customize_inline_css', $css );

	return $css->build();
}

/**
 * Add inline CSS based on configuration data.
 *
 * @since 1.16.0
 *
 * @param BigBox\Customize\Build_Inline_CSS $css CSS object to handle building inline output.
 * @param string                            $key                            Configuration key.
 * @param array                             $config                          Configuration data.
 */
function bigbox_customize_add_inline_css_by_config( $css, $key, $config ) {
	/**
	 * Filter the inline CSS configuration for each control.
	 *
	 * @since 1.11.0
	 *
	 * @param array $data CSS configuration data.
	 */
	$config = apply_filters( 'bigbox_customize_inline_css_' . $key, $config );

	foreach ( $config as $data ) {
		$css->add( $data );
	}
}

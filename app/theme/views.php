<?php
/**
 * View helper functions.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Bootstrap
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Render a view.
 *
 * @since 1.0.0
 *
 * @param string|array $templates The name of the template.
 * @param array        $args Variables to pass to partial.
 * @param string       $path Optional non-default path.
 */
function bigbox_view( $templates, $args = [], $path = 'resources/views' ) {
	echo bigbox_get_view( $templates, $args, $path );
}

/**
 * Locate a piece of template.
 *
 * @since 1.0.0
 *
 * @param string|array $templates The name of the template.
 * @param array        $args Variables to pass to partial.
 * @param string       $path Optional non-default path.
 */
function bigbox_get_view( $templates, $args = [], $path = 'resources/views' ) {
	if ( ! is_array( $templates ) ) {
		$templates = [ $templates ];
	}

	// Extract variable to use in template file.
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args ); // @codingStandardsIgnoreLine
	}

	$_templates = [];

	foreach ( $templates as $key => $template_name ) {
		$_templates[] = $template_name . '.php';
		$_templates[] = trailingslashit( $path ) . $template_name . '.php';
	}

	$template = locate_template( $_templates );

	ob_start();

	if ( $template ) {
		include $template;
	}

	return ob_get_clean();
}

/**
 * Output a partial.
 *
 * @since 1.0.0
 *
 * @param string $partial The file name of the partial to load.
 * @param array  $args Variables to pass to partial.
 */
function bigbox_partial( $partial, $args = [] ) {
	echo bigbox_get_partial( $partial, $args ); // XSS: ok.
}

/**
 * Load a template partial in to the output buffer.
 *
 * This serves mainly as an alias for `bigbox_view()` but always looks
 * in the `/partials` directory.
 *
 * @since 1.0.0
 *
 * @param string $partial The file name of the partial to load.
 * @param array  $args Variables to pass to partial.
 * @return string
 */
function bigbox_get_partial( $partial, $args = [] ) {
	ob_start();

	bigbox_view( 'partials/' . $partial, $args );

	return ob_get_clean();
}

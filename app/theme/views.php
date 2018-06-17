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
 * @param string|array   $templates The name of the template.
 * @param array          $args Variables to pass to partial.
 * @param (false|string) $path Optional view base path.
 */
function bigbox_view( $templates, $args = [], $path = false ) {
	\BigBoxWC\WP_Template_Loader\Loader::view( $templates, $args, $path );
}

/**
 * Locate a piece of template.
 *
 * @since 1.0.0
 *
 * @param string|array   $templates The name of the template.
 * @param array          $args Variables to pass to partial.
 * @param (false|string) $path Optional view base path.
 */
function bigbox_get_view( $templates, $args = [], $path = false ) {
	return \BigBoxWC\WP_Template_Loader\Loader::get_view( $templates, $args, $path );
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
	\BigBoxWC\WP_Template_Loader\Loader::partial( $partial, $args ); // XSS: ok.
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
	return \BigBoxWC\WP_Template_Loader\Loader::get_partial( $partial, $args );
}

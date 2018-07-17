<?php
/**
 * Modify some of WordPress' global functionality.
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

/**
 * Plug in to get_search_form() and override with our own partial.
 *
 * @see https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @since 1.0.0
 *
 * @return string
 */
add_filter(
	'get_search_form', function() {
		return bigbox_get_partial( 'searchform' );
	}
);

/**
 * Add rounded corners to body by default.
 *
 * @since 1.0.0
 *
 * @param array $classes Body classes.
 * @return array
 */
add_filter( 'body_class', function( $classes ) {
	/**
	 * Filters if the styles should use rounded corners.
	 *
	 * @since 1.11.0
	 *
	 * @param bool
	 */
	$rounded = apply_filters(
		'bigbox_is_rounded', true
	);

	$classes[] = $rounded ? 'is-rounded': null;

	return $classes;
);

/**
 * Add rounded corners to admin body by default.
 *
 * @since 1.0.0
 *
 * @param string $classes Body classes.
 * @return string
 */
add_filter(
	'admin_body_class', function( $classes ) {
		$classes = $classes . ' is-rounded ';

		return $classes;
	}
);

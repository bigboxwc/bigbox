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
 * Override get_search_form().
 */
add_filter(
	'get_search_form',

	/**
	 * Override get_search_form().
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function() {
		return bigbox_get_partial( 'searchform' );
	}
);

/**
 * Add rounded corners to body by default.
 */
add_filter(
	'body_class',

	/**
	 * Add rounded corners to body by default.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Body classes.
	 * @return array
	 */
	function( $classes ) {
		// @codingStandardsIgnoreStart
		/**
		 * Filters if the styles should use rounded corners.
		 *
		 * @since 1.11.0
		 *
		 * @param bool
		 */
		$rounded = apply_filters( 'bigbox_is_rounded', true );

		$classes[] = $rounded ? 'is-rounded' : null;
		// @codingStandardsIgnoreEnd

		return $classes;
	}
);

/**
 * Add rounded corners to admin body by default.
 */
add_filter(
	'admin_body_class',

	/**
	 * Add rounded corners to admin body by default.
	 *
	 * @since 1.0.0
	 *
	 * @param string $classes Body classes.
	 * @return string
	 */
	function( $classes ) {
		$classes = $classes . ' is-rounded ';

		return $classes;
	}
);

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
 *
 * @since 1.0.0
 *
 * @param array $classes Body classes.
 * @return array
 */
function bigbox_body_class( $classes ) {
	if ( bigbox_is_rounded() ) {
		$classes[] = 'is-rounded';
	}

	return $classes;
}
add_filter( 'body_class', 'bigbox_body_class' );

/**
 * Output theme (and child theme) version number in meta tag.
 *
 * @since 1.0.0
 *
 * @param string $gen  Generator.
 * @param string $type Type.
 * @return string
 */
function bigbox_generator( $gen, $type ) {
	$theme = wp_get_theme( get_template() );
	$items = [ $theme->Name . ' ' . $theme->Version ]; // phpcs:ignore WordPress.NamingConventions.ValidVariableName

	if ( is_child_theme() ) {
		$child_theme = wp_get_theme( get_stylesheet() );
		$items[]     = $child_theme->Name . ' ' . $child_theme->Version; // phpcs:ignore WordPress.NamingConventions.ValidVariableName
	}

	foreach ( $items as $item ) {
		$gen .= "\n" . '<meta name="generator" content="' . esc_attr( $item ) . '"' . ( 'xhtml' === $type ? ' /' : null ) . '>';
	}

	return $gen;
}
add_action( 'get_the_generator_html', 'bigbox_generator', 10, 2 );
add_action( 'get_the_generator_xhtml', 'bigbox_generator', 10, 2 );

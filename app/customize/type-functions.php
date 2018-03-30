<?php
/**
 * Type helper functions.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

/**
 * Get the chosen family.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_get_theme_font_family() {
	$family = get_theme_mod( 'type-font-family', 'default' );

	if ( 'default' === $family ) {
		return false;
	}

	return $family;
}

/**
 * Get the chosen weight.
 *
 * @since 1.0.0
 *
 * @param string $weight Weight to get.
 * @return string
 */
function bigbox_get_theme_font_weight( $weight = 'base' ) {
	$weight = get_theme_mod( "type-font-weight-{$weight}", 400 );

	if ( 'regular' === $weight ) {
		return 400;
	}

	return $weight;
}

/**
 * Create a URL for to load a Google font.
 *
 * @since 1.0.0
 *
 * @return mixed URL if needed. False otherwise.
 */
function bigbox_get_google_fonts_url() {
	$family = bigbox_get_theme_font_family();

	if ( ! $family || 'default' == $family ) {
		return false;
	}

	$base = bigbox_get_theme_font_weight( 'base' );
	$bold = bigbox_get_theme_font_weight( 'bold' );

	$weights = implode( ',', [ $base, $bold ] );
	$family  = urlencode( $family );

	$url = '//fonts.googleapis.com/css';

	return esc_url_raw( add_query_arg( [ 'family' => $family . ':' . $weights ], $url ) );
}

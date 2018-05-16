<?php
/**
 * Color helper functions.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

/**
 * Get color configs.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_get_theme_colors() {
	return include get_template_directory() . '/app/customize/config/colors.php';
}

/**
 * Get a color.
 *
 * @since 1.0.0
 *
 * @param string $key Color key.
 * @return mixed String or false on no value.
 */
function bigbox_get_theme_color( $key ) {
	return get_theme_mod( "color-{$key}", bigbox_get_theme_default_color( $key ) );
}

/**
 * Get a default color.
 *
 * @since 1.0.0
 *
 * @param  string $key Color key.
 * @return mixed String or false on no default.
 */
function bigbox_get_theme_default_color( $key ) {
	$colors = bigbox_get_theme_colors();

	if ( isset( $colors[ $key ] ) ) {
		return $colors[ $key ]['color'];
	}

	return false;
}

/**
 * Convert a HEX value to RGBA.
 *
 * @since 1.0.0
 *
 * @param string $color HEX value.
 * @param int    $opacity Opacity to use.
 * @return string
 */
function bigbox_hex_to_rgba( $color, $opacity = false ) {
	if ( '#' === $color[0] ) {
		$color = substr( $color, 1 );
	}

	if ( 6 === strlen( $color ) ) {
		$hex = [ $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] ];
	} elseif ( 3 === strlen( $color ) ) {
		$hex = [ $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] ];
	} else {
		return $color;
	}

	$rgb = array_map( 'hexdec', $hex );

	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}

		$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ',', $rgb ) . ')';
	}

	return $output;
}

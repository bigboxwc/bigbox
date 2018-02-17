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
 * Wrap embeds so we can make them responsive.
 *
 * @since 1.0.0
 *
 * @param string $html Embed HTML.
 * @return string
 */
function bigbox_embed_html( $html ) {
	return '<div class="wp-embed">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'bigbox_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'bigbox_embed_html' ); // Jetpack.

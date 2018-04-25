<?php
/**
 * Searching in the nav bar.
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
 * Filters the HTML for the search in the navbar.
 *
 * @since 1.0.0
 *
 * @param string
 */
echo apply_filters( 'bigbox_navbar_search', '' ); // WPCS: XSS okay.

<?php
/**
 * FacetWP template functions.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Output FacetWP pagination.
 *
 * @since 1.0.0
 */
function bigbox_facetwp_pagination() {
	echo do_shortcode( '[facetwp pager="true"]' );
}

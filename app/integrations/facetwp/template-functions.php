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

/**
 * Modify the output of the pagination.
 *
 * @since 1.0.0
 *
 * @param string $output Current output.
 * @param array  $params An associative array of result count settings.
 * @return string
 */
function bigbox_facetwp_pagination_output( $output, $params ) {
	$page        = $params['page'];
	$total_pages = $params['total_pages'];

	$prev = '';
	$next = '';

	if ( $page > 1 ) {
		$prev = '<a data-page="' . ( $page - 1 ) . '" class="facetwp-page prev">' . esc_html__( '&larr; Previous Page', 'bigbox' ) . '</a>';
	}

	if ( $page < $total_pages && $total_pages > 1 ) {
		$next = '<a data-page="' . ( $page + 1 ) . '" class="facetwp-page next">' . esc_html__( 'Next Page &rarr;', 'bigbox' ) . '</a>';
	}

	return $prev . $output . $next;
}

/**
 * Output FacetWP result count.
 *
 * @since 1.0.0
 */
function bigbox_facetwp_result_count() {
	echo do_shortcode( '[facetwp counts="true"]' );
}

/**
 * Modify the output of the result count.
 *
 * @since 1.0.0
 *
 * @param string $output Current output.
 * @param array  $params An associative array of result count settings.
 * @return string
 */
function bigbox_facetwp_result_count_output( $output, $params ) {
	if ( $params['lower'] === $params['upper'] || 1 === $params['total'] ) {
		/* translators: %d: total results */
		return sprintf( _n( 'Showing the single result', 'Showing all %d results', $params['total'], 'bigbox' ), $params['total'] );
	}

	return sprintf( 
		// Translators: %1$s Lower count. %2$s Upper count. %3$s Total count.
		__( 'Showing %1$s&ndash;%2$s of %3$s results', 'bigbox' ),
		$params['lower'],
		$params['upper'],
		$params['total']
	);
}

/**
 * Output FacetWP catalog ordering.
 *
 * @since 1.0.0
 */
function bigbox_facetwp_catalog_ordering() {
	echo do_shortcode( '[facetwp sort="true"]' );
}

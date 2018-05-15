<?php
/**
 * Register default facets.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

/**
 * Register default facets.
 *
 * @since 1.0.0
 *
 * @param array $facets Current facets.
 * @return array
 */
function bigbox_facetwp_facets( $facets ) {
	$facets[] = array(
		'label'         => 'Keywords',
		'name'          => 'keyword',
		'type'          => 'search',
		'search_engine' => '',
		'placeholder'   => 'Find a product...',
	);

	$facets[] = array(
		'label'       => 'Categories',
		'name'        => 'category',
		'type'        => 'dropdown',
		'placeholder' => 'All',
		'source'      => 'tax/product_category',
	);

	return $facets;
}
add_filter( 'facetwp_facets', 'bigbox_facetwp_facets' );

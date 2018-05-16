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
	// Remove the default Categories checkbox.
	foreach ( $facets as $index => $facet ) {
		if ( 'tax/category' === $facet['source'] && 'checkboxes' === $facet['type'] ) {
			unset( $facets[ $index ] );
		}
	}

	$facets[] = array(
		'label'         => 'Keywords',
		'name'          => 'keyword',
		'type'          => 'search',
		'search_engine' => '',
		'placeholder'   => 'Find a product...',
	);

	$facets[] = array(
		'label'        => 'Categories',
		'name'         => 'category',
		'type'         => 'dropdown',
		'label_any'    => 'All',
		'source'       => 'tax/product_cat',
		'hierarchical' => 'no',
		'orderby'      => 'count',
		'count'        => 0,
	);

	return $facets;
}
add_filter( 'facetwp_facets', 'bigbox_facetwp_facets' );

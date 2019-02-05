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
		if ( ! isset( $facet['source'] ) ) {
			continue;
		}

		if ( 'tax/category' === $facet['source'] && 'checkboxes' === $facet['type'] ) {
			unset( $facets[ $index ] );
		}
	}

	$facets[] = [
		'label'         => 'Keywords',
		'name'          => 'keyword',
		'type'          => 'search',
		'search_engine' => '',
		'placeholder'   => '',
	];

	$facets[] = [
		'label'        => 'Categories',
		'name'         => 'categories',
		'type'         => 'dropdown',
		'label_any'    => 'All',
		'source'       => 'tax/product_cat',
		'hierarchical' => 'no',
		'orderby'      => 'count',
		'count'        => 0,
	];

	$facets[] = [
		'label'  => 'Price',
		'name'   => 'price',
		'type'   => 'slider',
		'source' => 'woo/regular_price',
		'prefix' => get_woocommerce_currency_symbol(),
		'suffix' => '',
		'format' => '0,0',
		'step'   => 1,
	];

	$facets[] = [
		'label'           => 'Sale',
		'name'            => 'sale',
		'type'            => 'checkboxes',
		'source'          => 'woo/on_sale',
		'ghosts'          => 'yes',
		'preserve-ghosts' => 'yes',
		'operator'        => 'and',
		'orderby'         => 'count',
		'count'           => 10,
		'limit'           => 0,
	];

	return $facets;
}
add_filter( 'facetwp_facets', 'bigbox_facetwp_facets' );

<?php
/**
 * FacetWP widget functionality.
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
 * Output default FacetWP widgets if the left sidebar is blank.
 *
 * @since 1.0.0
 *
 * @param string $content Sidebar HTML content.
 * @return string
 */
function bigbox_facetwp_dynamic_sidebar_shop( $content ) {
	if ( '' !== $content ) {
		return $content;
	}

	ob_start();

	// Price filter.
	the_widget(
		'WP_Widget_Text',
		[
			'title' => 'Filter by price',
			'text'  => '[facetwp facet="price"]',
		],
		bigbox_woocommerce_shop_sidebar_args()
	);

	// On sale.
	the_widget(
		'WP_Widget_Text',
		[
			'title' => 'On sale',
			'text'  => '[facetwp facet="sale"]',
		],
		bigbox_woocommerce_shop_sidebar_args()
	);

	return ob_get_clean();
}
remove_filter( 'bigbox_dynamic_sidebar_shop', 'bigbox_woocommerce_dynamic_sidebar_shop' );
add_filter( 'bigbox_dynamic_sidebar_shop', 'bigbox_facetwp_dynamic_sidebar_shop' );

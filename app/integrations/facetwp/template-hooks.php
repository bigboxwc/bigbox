<?php
/**
 * FacetWP template hooks.
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

// Custom scripts.
add_action( 'wp_enqueue_scripts', 'bigbox_facetwp_wp_enqueue_scripts' );

/**
 * File: resources/views/partials/navbar-search.php.
 */

remove_all_filters( 'bigbox_navbar_search' );
add_filter( 'bigbox_navbar_search', 'bigbox_facetwp_navbar_search' );

/**
 * File: woocommerce/templates/archive-product.php.
 */

// Manually set up our loop tags.
add_action( 'init', 'bigbox_facetwp_loop' );

// Preselect on archives.
add_filter( 'facetwp_template_use_archive', '__return_true' );

// Add pagination.
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
add_action( 'woocommerce_after_shop_loop', 'bigbox_facetwp_pagination' );

add_filter( 'facetwp_pager_html', 'bigbox_facetwp_pagination_output', 10, 2 );

// Replace WooCommerce's "Results Showing" and sorting options.
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_before_shop_loop', 'bigbox_facetwp_result_count', 20 );
add_action( 'woocommerce_before_shop_loop', 'bigbox_facetwp_catalog_ordering', 30 );

add_filter( 'facetwp_result_count', 'bigbox_facetwp_result_count_output', 10, 2 );

// Add custom sort options.
add_filter( 'facetwp_sort_options', 'bigbox_facetwp_sort_options' );

// Match "No Results Found" with WooCommerce.
add_filter( 'gettext', 'bigbox_facetwp_gettext_no_results', 20, 3 );

/**
 * General
 */

// Dynamic shop page filters.
add_filter( 'navbar_dropdown_search_source', 'bigbox_navbar_dropdown_search_source', 10, 3 );

/**
 * [products] shortcode.
 *
 * Added here instead of WooCommerce because they only need to be modfied to work with FacetWP.
 */

/**
 * File: includes/shortcodes/class-wc-shortcode-products.php.
 */
add_filter( 'shortcode_atts_products', 'bigbox_woocommerce_shortcode_atts_products' );
add_filter( 'woocommerce_shortcode_products_query', 'bigbox_woocommerce_shortcode_products_query' );
add_filter( 'facetwp_is_main_query', 'bigbox_facetwp_is_main_query', 10, 2 );

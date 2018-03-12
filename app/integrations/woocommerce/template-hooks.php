<?php
/**
 * WooCommerce template hooks.
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

// Remove extra styles.
add_filter( 'woocommerce_enqueue_styles', 'bigbox_woocommerce_enqueue_styles' );

// Look in the integration for templates.
add_filter( 'woocommerce_template_path', 'bigbox_woocommerce_template_path' );

/**
 * @see archive-product.php
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

add_action( 'woocommerce_before_main_content', 'bigbox_woocommerce_output_content_wrapper' );
add_action( 'woocommerce_after_main_content', 'bigbox_woocommerce_output_content_wrapper_end' );

add_filter( 'woocommerce_after_output_product_categories', 'bigbox_woocommerce_after_output_product_categories' );

/**
 * @see content-product.php
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'bigbox_woocommerce_after_shop_loop_item_title_variations', 8 );

add_action( 'woocommerce_before_shop_loop_item', function() {
	echo '<div class="product__inner">';
} );

add_action( 'woocommerce_after_shop_loop_item', function() {
	echo '</div>';
} );

/**
 * @see archive-product.php
 */
add_filter( 'woocommerce_show_page_title', '__return_false' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

if ( is_woocommerce() ) {
	add_action( 'bigbox_navbar_after', 'woocommerce_breadcrumb' );
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );

/**
 * @see single-product.php
 */
add_action( 'the_post', function() {
	if ( is_singular( 'product' ) ) {
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
	}
} );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );

/**
 * @see wc-formatting-functions.php
 */
add_filter( 'woocommerce_get_star_rating_html', 'bigbox_woocommerce_get_star_rating_html', 10, 3 );

/**
 * @see wc-template-functions.php
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'bigbox_woocommerce_breadcrumb_defaults' );

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

// Load custom page templates.
add_filter( 'theme_page_templates', 'bigbox_woocommerce_page_templates' );

/**
 * @see content-single-product.php
 */

/**
 * @see archive-product.php
 */

// Replace outer content wrapper.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

add_action( 'woocommerce_before_main_content', 'bigbox_woocommerce_output_content_wrapper' );
add_action( 'woocommerce_after_main_content', 'bigbox_woocommerce_output_content_wrapper_end' );

add_filter( 'woocommerce_after_output_product_categories', 'bigbox_woocommerce_after_output_product_categories' );

// Wrap result count and ordering.
add_action( 'woocommerce_before_shop_loop', 'bigbox_woocommerce_before_shop_loop', 15 );
add_action( 'woocommerce_before_shop_loop', 'bigbox_woocommerce_before_shop_loop_after', 35 );

// Move breadcrumb under navbar.
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'bigbox_navbar_after', 'woocommerce_breadcrumb' );

/**
 * @see content-product.php
 */

// Add extra markup inside product.
add_action( 'woocommerce_before_shop_loop_item', 'bigbox_woocommerce_before_shop_loop_item' );
add_action( 'woocommerce_after_shop_loop_item', 'bigbox_woocommerce_after_shop_loop_item' );

// Remove wrapping anchor tag.
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

// Remove add to cart.
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

// Adjust position of title, sale, rating, and price output.
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5 );

// Add note about variations.
add_action( 'woocommerce_after_shop_loop_item_title', 'bigbox_woocommerce_after_shop_loop_item_title_variations', 8 );

/**
 * @see content-single-product.php
 */

// Remove sidebar on single product pages.
add_action( 'the_post', function() {
	if ( is_singular( 'product' ) ) {
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
	}
} );

// Filter product tabs.
add_filter( 'woocommerce_product_tabs', 'bigbox_woocommerce_product_tabs', 20 );

// Remove sale flash (output in price template).
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );

// Adjust rating position.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );

// Adjust add to cart position.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

// Add custom purchase form.
add_action( 'woocommerce_after_single_product_summary', 'bigbox_purchase_form', 5 );
add_action( 'bigbox_purchase_form', 'woocommerce_template_single_add_to_cart' );

// Adjust sharing position.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
add_action( 'bigbox_purchase_form', 'woocommerce_template_single_sharing', 20 );

// Remove related and upsells (added back with tabs).
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

// Add product meta to the Additional Information tab.
add_action( 'woocommerce_product_additional_information', 'bigbox_woocommerce_product_additional_information', 99 );

// Always show Additional Information.
add_filter( 'wc_product_enable_dimensions_display', '__return_true' );

/**
 * @see wc-formatting-functions.php
 */

// Custom rating stars.
add_filter( 'woocommerce_get_star_rating_html', 'bigbox_woocommerce_get_star_rating_html', 10, 3 );

/**
 * @see wc-template-functions.php
 */

// Custom breadcrum arguments.
add_filter( 'woocommerce_breadcrumb_defaults', 'bigbox_woocommerce_breadcrumb_defaults' );

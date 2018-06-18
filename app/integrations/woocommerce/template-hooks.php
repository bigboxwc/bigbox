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

// Modify global JS settings.
add_filter( 'bigbox_js', 'bigbox_woocommerce_js_settings' );

// Remove cart fragments on standard shop pages.
add_filter( 'wp_enqueue_scripts', 'bigbox_woocommerce_wp_enqueue_scripts', 20 );

/**
 * File: resources/views/partials/navbar-search.php.
 */

add_filter( 'bigbox_navbar_search', 'bigbox_woocommerce_navbar_search' );

/**
 * File: archive-product.php.
 */

// Replace outer content wrapper.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

add_action( 'woocommerce_before_main_content', 'bigbox_woocommerce_output_content_wrapper' );
add_action( 'woocommerce_after_main_content', 'bigbox_woocommerce_template_close_div' );

add_filter( 'woocommerce_after_output_product_categories', 'bigbox_woocommerce_after_output_product_categories' );
add_filter( 'woocommerce_product_subcategories_args', 'bigbox_woocommerce_product_subcategories_args' );

// Wrap result count and ordering.
add_action( 'woocommerce_before_shop_loop', 'bigbox_woocommerce_before_shop_loop', 15 );
add_action( 'woocommerce_before_shop_loop', 'bigbox_woocommerce_template_close_div', 55 );

// Move breadcrumb under navbar.
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

if ( bigbox_is_shop() ) {
	add_action( 'bigbox_navbar_after', 'woocommerce_breadcrumb' );
}

// Update pagination.
add_filter( 'woocommerce_pagination_args', 'bigbox_woocommerce_pagination_args' );

// Mobile filters.
add_action( 'woocommerce_before_shop_loop', 'bigbox_woocommerce_archive_mobile_filters', 25 );

/**
 * File: content-product.php.
 */

// Add extra markup inside product.
add_action( 'woocommerce_before_shop_loop_item', 'bigbox_woocommerce_before_shop_loop_item' );
add_action( 'woocommerce_after_shop_loop_item', 'bigbox_woocommerce_template_close_div' );

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

add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'bigbox_woocommerce_template_loop_variations', 8 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'bigbox_woocommerce_template_loop_stock', 15 );

/**
 * File: content-single-product.php.
 */

// Remove sidebar on single product pages.
add_action( 'wp', 'bigbox_woocommerce_template_tertiary' );

// Filter product tabs.
add_filter( 'woocommerce_product_tabs', 'bigbox_woocommerce_product_tabs', 20 );

// Only output attributes if there are any.
remove_action( 'woocommerce_product_additional_information', 'wc_display_product_attributes', 10 );
add_action( 'woocommerce_product_additional_information', 'bigbox_woocommerce_display_product_attributes', 10 );

// Remove sale flash (output in price template).
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );

// Adjust add to cart position.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

add_action( 'woocommerce_single_product_summary', 'bigbox_woocommerce_single_product_summary_inner', -1 );
add_action( 'woocommerce_single_product_summary', 'bigbox_woocommerce_template_close_div', 499 );

add_action( 'woocommerce_single_product_summary', 'bigbox_add_to_cart', 500 );
add_action( 'bigbox_purchase_form', 'woocommerce_template_single_add_to_cart' );

// Adjust sharing position.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
add_action( 'bigbox_purchase_form_after', 'woocommerce_template_single_sharing' );

// Remove related and upsells (added back with tabs).
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15, 4 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_filter( 'woocommerce_output_related_products_args', 'bigbox_woocommerce_output_related_products_args' );
add_filter( 'woocommerce_upsell_display_args', 'bigbox_woocommerce_output_related_products_args' );

// Add product meta to the Additional Information tab.
add_action( 'woocommerce_product_additional_information', 'bigbox_woocommerce_product_additional_information', 99 );

// Always show Additional Information.
add_filter( 'wc_product_enable_dimensions_display', '__return_true' );

// Adjust gallery output.
add_filter( 'woocommerce_single_product_carousel_options', 'bigbox_woocommerce_single_product_carousel_options' );

/**
 * File: templates/cart/cart.php.
 */

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals' );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

add_filter(
	'woocommerce_cross_sells_total', function() {
		return wc_get_default_products_per_row() * 2;
	}
);

add_filter(
	'woocommerce_cross_sells_columns', function() {
		return wc_get_default_products_per_row();
	}
);

/**
 * File: wc-formatting-functions.php.
 */

// Custom rating stars.
add_filter( 'woocommerce_get_star_rating_html', 'bigbox_woocommerce_get_star_rating_html', 10, 3 );

/**
 * File: wc-template-functions.php.
 */

// Custom breadcrumb arguments.
add_filter( 'woocommerce_breadcrumb_defaults', 'bigbox_woocommerce_breadcrumb_defaults' );

// Demo store notice.
add_filter( 'woocommerce_demo_store', 'bigbox_woocommerce_demo_store' );

/**
 * File: single-product/review.php
 */

// Move gravatar position.
remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar' );
add_action( 'woocommerce_review_meta', 'woocommerce_review_display_gravatar', 5 );

// Move rating output.
remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating' );
add_action( 'woocommerce_review_meta', 'woocommerce_review_display_rating', 15 );

/**
 * File: class-wc-widget-cart.php
 */
add_filter( 'woocommerce_widget_cart_is_hidden', 'bigbox_woocommerce_widget_cart_is_hidden' );

/**
 * File: checkout/form-checkout.php
 */

// Relocate coupon form. Manaully output.
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

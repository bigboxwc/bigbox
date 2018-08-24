<?php
/**
 * WooCommerce Brands template hooks.
 *
 * @since 1.14.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$wcpv = new WC_Product_Vendors_Vendor_Frontend();

// Filter shortcode-registration-form.php template location.
add_filter(
	'woocommerce_locate_template',
	function( $template, $template_name ) {
		if ( 'shortcode-registration-form.php' === $template_name ) {
			return get_theme_file_path( 'app/integrations/woocommerce-product-vendors/templates/shortcode-registration-form.php' );
		};

		return $template;
	},
	10,
	2
);

// Change "Sold by" on loop.
remove_class_action( 'woocommerce_after_shop_loop_item', 'WC_Product_Vendors_Vendor_Frontend', 'add_sold_by_loop', 9 );
add_action( 'woocommerce_after_shop_loop_item', 'bigbox_wcpv_add_sold_by_loop', 9 );

// Move "Sold by" on product page.
remove_class_action( 'woocommerce_single_product_summary', 'WC_Product_Vendors_Vendor_Frontend', 'add_sold_by_single', 39 );
add_action( 'woocommerce_product_additional_information', [ $wcpv, 'add_sold_by_single' ], 99 );

// Override vendor profile on archive page.
remove_class_action( 'woocommerce_archive_description', 'WC_Product_Vendors_Vendor_Frontend', 'display_vendor_logo_profile' );
add_action( 'woocommerce_archive_description', 'bigbox_wcpv_display_vendor_logo_profile' );

add_filter( 'woocommerce_page_title', 'bigbox_wcpv_vendor_page_title' );

// Rating HTML.
add_filter( 'wcpv_vendor_get_rating_html', 'bigbox_wcpv_vendor_get_rating_html', 10, 2 );

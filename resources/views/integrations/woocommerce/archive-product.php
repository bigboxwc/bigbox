<?php
/**
 * This is a placeholder.
 *
 * This template is used to track the version of the core archive-product.php
 * template file. It is used to alert of any changes made so archive-product-page.php
 * can be updated accordingly.
 *
 * @since 1.0.0
 * @version 3.4.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

remove_filter( 'woocommerce_template_path', 'bigbox_woocommerce_template_path' );

$archive = wc_locate_template( 'archive-product.php' );

add_filter( 'woocommerce_template_path', 'bigbox_woocommerce_template_path' );

if ( $archive ) {
	include $archive;
}

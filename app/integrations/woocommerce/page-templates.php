<?php
/**
 * WooCommerce page templates.
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

/**
 * Filter returned page templates.
 *
 * @since 1.0.0
 *
 * @param array $page_templates The current list of templates.
 */
function bigbox_woocommerce_page_templates( $page_templates ) {
	$page_templates[ bigbox_woocommerce_template_path() . 'cart.php' ] = esc_html__( 'Cart', 'bigbox' );
	$page_templates[ bigbox_woocommerce_template_path() . 'checkout.php' ] = esc_html__( 'Checkout', 'bigbox' );

	return $page_templates;
}
add_filter( 'theme_page_templates', 'bigbox_woocommerce_page_templates' );

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
 * Auto apply page templates to assigned WooCommerce pages.
 *
 * @since 1.0.0
 *
 * @param array $templates The current list of templates.
 * @return array
 */
function bigbox_woocommerce_page_templates( $templates ) {
	if ( is_cart() ) {
		$templates = array_merge( [ bigbox_woocommerce_template_path() . 'cart.php' ], $templates );
	}

	if ( is_checkout() ) {
		$templates = array_merge( [ 'resources/views/layout/minimal.php' ], $templates );
	}

	if ( is_account_page() && ! is_user_logged_in() ) {
		if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
			$templates = array_merge( [ 'resources/views/layout/minimal.php' ], $templates );
		} else {
			$templates = array_merge( [ 'resources/views/layout/minimal-5.php' ], $templates );
		}
	}

	return $templates;
}
add_filter( 'page_template_hierarchy', 'bigbox_woocommerce_page_templates', 5 );

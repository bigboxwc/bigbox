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
	$add = [];

	if ( is_cart() ) {
		$add[] = bigbox_woocommerce_template_path() . 'cart.php';
	}

	if ( is_checkout() ) {
		$add[] = 'resources/views/layout/minimal.php';
	}

	if ( is_account_page() && ! is_user_logged_in() ) {
		if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
			$add[] = 'resources/views/layout/minimal.php';
		} else {
			$add[] = 'resources/views/layout/minimal-5.php';
		}
	} else if ( is_account_page() && is_user_logged_in() ) {
		$add[] = 'resources/views/layout/narrow.php';
	}

	if ( ! empty( $add ) ) {
		$templates = array_merge( $add, $templates );
	}

	return $templates;
}
add_filter( 'page_template_hierarchy', 'bigbox_woocommerce_page_templates', 5 );

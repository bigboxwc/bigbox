<?php
/**
 * WooCommerce template functions.
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
 * Remove any default styles.
 *
 * @since 1.0.0
 *
 * @param array $styles Style slugs to load.
 * @return array
 */
function bigbox_woocommerce_enqueue_styles( $styles ) {
	unset( $styles['woocommerce-general'] );
	unset( $styles['woocommerce-smallscreen'] );

	return $styles;
}

/**
 * Look in the integration for templates.
 *
 * @since 1.0.0
 *
 * @param string $path Current template path.
 * @return string
 */
function bigbox_woocommerce_template_path( $path ) {
	return 'app/integrations/woocommerce/views';
}

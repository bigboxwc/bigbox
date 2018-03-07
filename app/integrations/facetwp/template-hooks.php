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

/**
 * @see woocommerce/templates/archive-product.php
 */
add_action( 'woocommerce_after_shop_loop', 'bigbox_facetwp_pagination' );

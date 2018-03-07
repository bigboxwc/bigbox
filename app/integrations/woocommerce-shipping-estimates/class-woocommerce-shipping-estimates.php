<?php
/**
 * WooCommerce Shipping Estimates integration.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

namespace BigBox\Integration;

use BigBox\Integration;
use BigBox\Registerable;
use BigBox\Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * FacetWP.
 *
 * @since 1.0.0
 */
class WooCommerceShippingEstimates extends Integration implements Registerable, Service {

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'woocommerce_shop_loop_item_title', [ $this, 'add_shipping_estimate' ], 20 );
	}

	/**
	 * Add note about shipping estimate.
	 *
	 * @since 1.0.0
	 */
	public function add_shipping_estimate() {
		global $product;

		if ( $product->is_virtual() ) {
			return;
		}

		echo '<div class="product__shipping product__stats">Ships in 4-7 days</div>';
	}

}

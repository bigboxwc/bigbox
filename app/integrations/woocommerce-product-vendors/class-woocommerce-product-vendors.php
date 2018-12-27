<?php
/**
 * WooCommerce Product Vendors integration.
 *
 * @since 1.14.0
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
 * WooCommerce Product Vendors.
 *
 * @since 1.14.0
 */
class WooCommerce_Product_Vendors extends Integration implements Registerable, Service {

	/**
	 * Additional functional files.
	 *
	 * @var array $helper_files
	 * @since 2.2.0
	 */
	protected $helper_files = [
		'template-hooks',
		'template-functions',
	];

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->load_helper_files();
	}

}

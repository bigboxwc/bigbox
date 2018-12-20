<?php
/**
 * WooCommerce Brands integration.
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
 * WooCommerce Brands.
 *
 * @since 1.0.0
 */
class WooCommerce_Brands extends Integration implements Registerable, Service {

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
	public function register() {}

}

<?php
/**
 * WooCommerce Bookings integration.
 *
 * @since 1.16.0
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
 * WooCommerce Bookings.
 *
 * @since 1.16.0
 */
class WooCommerce_Bookings extends Integration implements Registerable, Service {

	// Inline CSS output files.
	protected $customize_inline_css_output = [
		'success',
		'gray-200',
		'gray-300',
		'gray-700',
		'type',
	];

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.16.0
	 */
	public function register() {
		include_once $this->get_dir() . '/template-hooks.php';
		include_once $this->get_dir() . '/template-functions.php';
	}

}

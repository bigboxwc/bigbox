<?php
/**
 * WooCommerce integration.
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
 * WooCommerce.
 *
 * @since 1.0.0
 */
class WooCommerce extends Integration implements Registerable, Service {

	/**
	 * Define the dependencies.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct(
			[
				defined( 'WC_PLUGIN_FILE' ) && WC_PLUGIN_FILE,
			],
			dirname( __FILE__ )
		);
	}

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'after_setup_theme', [ $this, 'add_theme_support' ] );
	}

	/**
	 * Add theme support.
	 *
	 * @since 1.0.0
	 */
	public function add_theme_support() {
		add_theme_support( 'woocommerce' );
	}
}

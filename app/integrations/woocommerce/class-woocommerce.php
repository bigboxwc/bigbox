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
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		include_once $this->get_dir() . '/wc-template-functions.php';

		include_once $this->get_dir() . '/template-hooks.php';
		include_once $this->get_dir() . '/template-functions.php';
		include_once $this->get_dir() . '/cart.php';
		include_once $this->get_dir() . '/checkout.php';
		include_once $this->get_dir() . '/account.php';
		include_once $this->get_dir() . '/widgets.php';
		include_once $this->get_dir() . '/emails.php';
		include_once $this->get_dir() . '/nav-menus.php';
		include_once $this->get_dir() . '/page-templates.php';
		include_once $this->get_dir() . '/customize.php';

		add_action( 'after_setup_theme', [ $this, 'add_theme_support' ] );
	}

	/**
	 * Add theme support.
	 *
	 * @since 1.0.0
	 */
	public function add_theme_support() {
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		add_theme_support(
			'woocommerce',
			apply_filters(
				'bigbox_woocommerce_theme_support',
				[
					'thumbnail_image_width'         => 200,
					'gallery_thumbnail_image_width' => 75,
					'single_image_width'            => 400,
					'product_grid'                  => [
						'default_columns' => 4,
						'min_columns'     => 1,
						'max_columns'     => 5,
					],
				]
			)
		);
	}
}

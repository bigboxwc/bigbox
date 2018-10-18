<?php
/**
 * Manage integrations.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integrations
 * @author Spencer Finnell
 */

namespace BigBox;

use BigBox\Registerable;
use BigBox\Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Integrations class.
 *
 * @since 1.0.0
 */
final class Integrations implements Registerable, Service {

	/**
	 * Register the theme with the WordPress system.
	 *
	 * @since 1.0.0
	 *
	 * @throws Exception\InvalidService If a integration is not valid.
	 */
	public function register() {
		add_action( 'after_setup_theme', [ $this, 'register_integrations' ], 9 );
	}

	/**
	 * Register the individual integrations of this theme.
	 *
	 * @since 1.0.0
	 *
	 * @throws Exception\InvalidIntegration If a integration is not valid.
	 */
	public function register_integrations() {
		$integrations = $this->get_integrations();
		$integrations = array_map( [ $this, 'instantiate_integration' ], $integrations );

		// Register.
		array_walk( $integrations, [ $this, 'register_integration' ] );
	}

	/**
	 * Register a single integration.
	 *
	 * @since 1.12.0
	 *
	 * @param Integration $integration Integration information.
	 */
	public function register_integration( Integration $integration ) {
		if ( $integration->is_active() ) {
			$integration->register();
		}
	}

	/**
	 * Instantiate a single integration.
	 *
	 * @since 1.0.0
	 *
	 * @param array $integration Integration information.
	 * @return Integration
	 * @throws Exception\InvalidIntegration If the integration is not valid.
	 */
	public function instantiate_integration( $integration ) {
		if ( ! class_exists( $integration['class'] ) ) {
			throw Exception\InvalidIntegration::from_integration( $integration['class'] );
		}

		$integration = new $integration['class']( $integration['slug'], $integration['dependencies'] );

		if ( ! $integration instanceof Integration ) {
			throw Exception\InvalidIntegration::from_integration( $integration );
		}

		return $integration;
	}

	/**
	 * Get the list of integrations to register.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of fully qualified class names.
	 */
	public function get_integrations() {
		$integrations = [
			'woocommerce'                 => [
				'slug'         => 'woocommerce',
				'class'        => Integration\WooCommerce::class,
				'dependencies' => [
					defined( 'WC_PLUGIN_FILE' ) && WC_PLUGIN_FILE,
				],
			],
			'woocommerce-brands'          => [
				'slug'         => 'woocommerce-brands',
				'class'        => Integration\WooCommerce_Brands::class,
				'dependencies' => [
					defined( 'WC_PLUGIN_FILE' ) && WC_PLUGIN_FILE,
					defined( 'WC_BRANDS_VERSION' ) && WC_BRANDS_VERSION,
				],
			],
			'woocommerce-product-vendors' => [
				'slug'         => 'woocommerce-product-vendors',
				'class'        => Integration\WooCommerce_Product_Vendors::class,
				'dependencies' => [
					defined( 'WC_PLUGIN_FILE' ) && WC_PLUGIN_FILE,
					defined( 'WC_PRODUCT_VENDORS_VERSION' ) && WC_PRODUCT_VENDORS_VERSION,
				],
			],
			'woocommerce-bookings' => [
				'slug'         => 'woocommerce-bookings',
				'class'        => Integration\WooCommerce_Bookings::class,
				'dependencies' => [
					defined( 'WC_PLUGIN_FILE' ) && WC_PLUGIN_FILE,
					defined( 'WC_BOOKINGS_VERSION' ) && WC_BOOKINGS_VERSION,
				],
			],
			'facetwp'                     => [
				'slug'         => 'facetwp',
				'class'        => Integration\FacetWP::class,
				'dependencies' => [
					defined( 'WC_PLUGIN_FILE' ) && WC_PLUGIN_FILE,
					defined( 'FACETWP_VERSION' ) && FACETWP_VERSION,
				],
			],
			'gutenberg'                   => [
				'slug'         => 'gutenberg',
				'class'        => Integration\Gutenberg::class,
				'dependencies' => [
					function_exists( 'the_gutenberg_project' ),
				],
			],
		];

		/**
		 * Filter registered integrations.
		 *
		 * @param array $services Fully qualified class names.
		 */
		return apply_filters( 'bigbox_integrations', $integrations );
	}

}

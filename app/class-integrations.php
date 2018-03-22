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
		add_action( 'after_setup_theme', [ $this, 'register_integrations' ], 5 );
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

		array_walk(
			$integrations, function( Integration $integration ) {
				if ( $integration->is_active() ) {
					$integration->register();
				}
			}
		);
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
		return [
			'woocommerce'                    => [
				'slug'         => 'woocommerce',
				'class'        => Integration\WooCommerce::class,
				'dependencies' => [
					defined( 'WC_PLUGIN_FILE' ) && WC_PLUGIN_FILE,
				],
			],
			'woocommerce-shipping-estimates' => [
				'slug'         => 'woocommerce-shipping-estimates',
				'class'        => Integration\WooCommerceShippingEstimates::class,
				'dependencies' => [
					defined( 'WC_PLUGIN_FILE' ) && WC_PLUGIN_FILE,
					class_exists( 'WC_Shipping_Estimate' ),
				],
			],
			'facetwp'                        => [
				'slug'         => 'facetwp',
				'class'        => Integration\FacetWP::class,
				'dependencies' => [
					defined( 'FACETWP_VERSION' ) && FACETWP_VERSION,
				],
			],
		];
	}

}

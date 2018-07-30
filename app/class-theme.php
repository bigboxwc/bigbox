<?php
/**
 * WordPress theme.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Bootstrap
 * @author Spencer Finnell
 */

namespace BigBox;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme class.
 *
 * @since 1.0.0
 */
final class Theme implements Registerable {

	/**
	 * Register the theme with the WordPress system.
	 *
	 * @since 1.0.0
	 *
	 * @throws Exception\InvalidService If a service is not valid.
	 */
	public function register() {
		add_action( 'after_setup_theme', [ $this, 'load_helpers' ], 5 );
		add_action( 'after_setup_theme', [ $this, 'register_services' ], 5 );
	}

	/**
	 * Load functional helpers.
	 *
	 * @since 1.0.0
	 */
	public function load_helpers() {
		require_once get_template_directory() . '/app/customize/customize.php';
		require_once get_template_directory() . '/app/nux/starter-content.php';

		$helpers = [
			'views',
			'template-tags',
			'assets',
			'svg',
			'nav-menus',
			'page-templates',
			'theme-support',
			'widgets',
			'wordpress',
			'lazyload',
		];

		foreach ( $helpers as $file ) {
			require_once get_template_directory() . '/app/theme/' . $file . '.php';
		}
	}

	/**
	 * Register the individual services of this plugin.
	 *
	 * @since 1.0.0
	 *
	 * @throws Exception\InvalidService If a service is not valid.
	 */
	public function register_services() {
		$services = $this->get_services();
		$services = array_map( [ $this, 'instantiate_service' ], $services );

		// Register.
		array_walk( $services, [ $this, 'register_service' ] );
	}

	/**
	 * Register a single service.
	 *
	 * @since 1.12.0
	 *
	 * @param Service $service service information.
	 */
	public function register_service( Service $service ) {
		return $service->register();
	}

	/**
	 * Instantiate a single service.
	 *
	 * @since 1.0.0
	 *
	 * @param string $class Service class to instantiate.
	 *
	 * @return Service
	 * @throws Exception\InvalidService If the service is not valid.
	 */
	private function instantiate_service( $class ) {
		if ( ! class_exists( $class ) ) {
			throw Exception\InvalidService::from_service( $class );
		}

		$service = new $class();

		if ( ! $service instanceof Service ) {
			throw Exception\InvalidService::from_service( $service );
		}

		return $service;
	}

	/**
	 * Get the list of services to register.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of fully qualified class names.
	 */
	private function get_services() {
		$services = [
			Integrations::class,
			NUX\Setup_Guide::class,
			NUX\License_Manager::class,
			NUX\Customize_Walkthrough::class,
		];

		/**
		 * Filter registered services.
		 *
		 * @param array $services Fully qualified class names.
		 */
		return apply_filters( 'bigbox_services', $services );
	}

}

<?php
/**
 * Manage an integration with a 3rd-party application.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

namespace BigBox;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Integration
 *
 * @since 1.0.0
 */
abstract class Integration {

	/**
	 * Track slug name.
	 *
	 * @var string $slug
	 * @since 1.16.0
	 */
	protected $slug;

	/**
	 * Current working directory.
	 *
	 * @var string $dir
	 * @since 1.0.0
	 */
	protected $dir;

	/**
	 * Current working path.
	 *
	 * A relative short path from the theme root.
	 *
	 * @var string $dir
	 * @since 1.0.0
	 */
	protected $local_path;

	/**
	 * List of required dependencies.
	 *
	 * @var array $active
	 * @since 1.0.0
	 */
	protected $dependencies;

	/**
	 * Additional functional files.
	 *
	 * @var array $helper_files
	 * @since 2.2.0
	 */
	protected $helper_files = [];

	/**
	 * Additional inline CSS configuration items.
	 *
	 * @var array $inline_css_configs
	 * @since 1.16.0
	 */
	protected $inline_css_configs = [];

	/**
	 * Setup integration.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug Integration slug.
	 * @param array  $dependencies List of required dependencies.
	 */
	public function __construct( $slug, $dependencies ) {
		$this->slug         = $slug;
		$this->dependencies = $dependencies;
		$this->local_path   = trailingslashit( '/app/integrations' ) . $slug;
		$this->dir          = get_template_directory() . $this->get_local_path();

		foreach ( $this->helper_files as $name ) {
			include_once trailingslashit( $this->get_dir() ) . $name . '.php';
		}
	}

	/**
	 * Get the integrations local working path.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_local_path() {
		return $this->local_path;
	}

	/**
	 * Get the integration's working directory.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_dir() {
		return $this->dir;
	}

	/**
	 * Get a list of required dependencies.
	 *
	 * @since 1.0.0
	 *
	 * @return array $dependencies List of required dependencies.
	 */
	public function get_dependencies() {
		return $this->dependencies;
	}

	/**
	 * Determine if this integration is active.
	 *
	 * @since 1.0.0
	 */
	public function is_active() {
		return ! in_array( false, $this->dependencies, true );
	}

	/**
	 * Load inline CSS if any output controls are defined.
	 *
	 * @since 1.16.0
	 *
	 * @param array $configs Output configurations.
	 * @return array $configs Output configurations with additional integration configurations.
	 */
	public function inline_css_configs( $configs ) {
		if ( empty( $this->inline_css_configs ) ) {
			return $configs;
		}

		foreach ( $this->inline_css_configs as $key ) {
			$configs[ $this->slug . '-' . $key ] = include $this->get_dir() . '/customize/output/' . $key . '.php';
		}

		return $configs;
	}

}

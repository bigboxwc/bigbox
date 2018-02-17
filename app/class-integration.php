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

namespace BigBox\Website;

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
	 * Current working directory.
	 *
	 * @var string $dir
	 * @since 1.0.0
	 */
	protected $dir = null;

	/**
	 * List of required dependencies.
	 *
	 * @var array $active
	 * @since 1.0.0
	 */
	protected $dependencies = [];

	/**
	 * If this integration is active and meets dependency requiremens.
	 *
	 * @var bool $active
	 * @since 1.0.0
	 */
	protected $active = false;

	/**
	 * Set the integration's working directory.
	 *
	 * @since 1.0.0
	 *
	 * @param string $dir The working directory.
	 */
	public function set_dir( $dir ) {
		$this->dir = $dir;
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
	 * Set a list of required dependencies.
	 *
	 * @since 1.0.0
	 *
	 * @param array $dependencies List of required dependencies.
	 */
	public function set_dependencies( $dependencies ) {
		$this->dependencies = $dependencies;
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
		if ( ! in_array( false, $this->dependencies, true ) ) {
			$this->active = true;
		}

		return (bool) $this->active;
	}

}

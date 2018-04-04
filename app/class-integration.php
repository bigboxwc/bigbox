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
	 * Current working directory.
	 *
	 * @var string $dir
	 * @since 1.0.0
	 */
	private $dir = null;

	/**
	 * Current working path.
	 *
	 * A relative short path from the theme root.
	 *
	 * @var string $dir
	 * @since 1.0.0
	 */
	private $local_path = null;

	/**
	 * List of required dependencies.
	 *
	 * @var array $active
	 * @since 1.0.0
	 */
	private $dependencies = [];

	/**
	 * If this integration is active and meets dependency requiremens.
	 *
	 * @var bool $active
	 * @since 1.0.0
	 */
	protected $active = false;

	/**
	 * Setup integration.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug Integration slug.
	 * @param array  $dependencies List of required dependencies.
	 */
	public function __construct( $slug, $dependencies ) {
		$this->dependencies = $dependencies;
		$this->local_path   = trailingslashit( '/app/integrations' ) . $slug;
		$this->dir          = get_template_directory() . $this->get_local_path();
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
		if ( ! in_array( false, $this->dependencies, true ) ) {
			$this->active = true;
		}

		return (bool) $this->active;
	}

}

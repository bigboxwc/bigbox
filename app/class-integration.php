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
	protected $dir = null;

	/**
	 * Current working path.
	 *
	 * A relative short path from the theme root.
	 *
	 * @var string $dir
	 * @since 1.0.0
	 */
	protected $local_path = null;

	/**
	 * List of required dependencies.
	 *
	 * @var array $active
	 * @since 1.0.0
	 */
	protected $dependencies = [];

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

		add_action( 'bigbox_customize_inline_css', [ $this, 'customize_inline_css' ] );
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
	 */
	public function customize_inline_css( $css ) {
		if ( ! isset( $this->customize_inline_css_output ) ) {
			return;
		}

		foreach ( $this->customize_inline_css_output as $key ) {
			$file = $this->get_dir() . '/customize/output/' . $key . '.php';

			if ( ! file_exists( $file ) ) {
				continue;
			}

			$config = include $file;

			foreach ( $config as $data ) {
				$css->add( $data );
			}
		}
	}

}

<?php
/**
 * FacetWP integration.
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
 * FacetWP.
 *
 * @since 1.0.0
 */
class FacetWP extends Integration implements Registerable, Service {

	/**
	 * Additional functional files.
	 *
	 * @var array $helper_files
	 * @since 2.2.0
	 */
	protected $helper_files = [
		'template-hooks',
		'template-functions',
		'default-facets',
		'customize',
	];

	/**
	 * Additional inline CSS configuration items.
	 *
	 * @var array $inline_css_configs
	 * @since 1.16.0
	 */
	protected $inline_css_configs = [
		'color-gray-200',
		'color-primary',
		'refresh',
	];

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->load_helper_files();

		add_filter( 'bigbox_customize_inline_css_configs', [ $this, 'inline_css_configs' ] );
	}

}

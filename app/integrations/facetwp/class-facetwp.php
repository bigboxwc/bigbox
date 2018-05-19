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
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		include_once $this->get_dir() . '/template-hooks.php';
		include_once $this->get_dir() . '/template-functions.php';
		include_once $this->get_dir() . '/default-facets.php';
		include_once $this->get_dir() . '/customize.php';
		include_once $this->get_dir() . '/widgets.php';
	}

}

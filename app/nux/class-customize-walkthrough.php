<?php
/**
 * A better way to use starter content.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */

namespace BigBox\NUX;

use BigBox\ThemeFactory;
use BigBox\Registerable;
use BigBox\Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Starter content.
 *
 * @since 1.0.0
 */
class Customize_Walkthrough implements Registerable, Service {

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_filter( 'bigbox_get_starter_content', [ $this, 'filter_starter_content' ], 99 );
	}

	/**
	 * Unset starter content if option is not checked.
	 *
	 * @since 1.0.0
	 *
	 * @param array $content Starter content.
	 * @return array
	 */
	public function filter_starter_content( $content ) {
		if ( is_customize_preview() && ! isset( $_GET['starter-content'] ) ) {
			$content = null;
		}

		return $content;
	}
}

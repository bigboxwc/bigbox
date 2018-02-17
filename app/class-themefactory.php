<?php
/**
 * Manage an instance of the theme.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Bootstrap
 * @author Spencer Finnell
 */

namespace BigBox\Website;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * ThemeFactory class.
 *
 * @since 1.0.0
 */
final class ThemeFactory {

	/**
	 * Create and return an instance of the theme.
	 *
	 * This always returns a shared instance.
	 *
	 * @since 1.0.0
	 *
	 * @return $theme Theme instance.
	 */
	public static function create() {
		static $theme = null;

		if ( null === $theme ) {
			$theme = new Theme();
		}

		return $theme;
	}

}

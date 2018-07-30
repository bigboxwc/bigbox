<?php
/**
 * Boostrap the application.
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

add_action(
	'after_setup_theme',
	function() {
		return ThemeFactory::create()
			->register();
	},
	0
);

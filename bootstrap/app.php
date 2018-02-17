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

ThemeFactory::create()->register();

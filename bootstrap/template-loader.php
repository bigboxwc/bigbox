<?php
/**
 * Supplement WordPress's template system.
 *
 * @link https://github.com/bigboxwc/wp-template-loader
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Bootstrap
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

( new \BigBoxWC\WP_Template_Loader\Loader() )::watch();

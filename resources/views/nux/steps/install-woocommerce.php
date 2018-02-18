<?php
/**
 * Install recommended plugins.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$plugin = new BigBox\NUX\WooCommerce_ListTable();
$plugin->prepare_items();
$plugin->display();

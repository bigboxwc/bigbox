<?php
/**
 * Customize(r) controls.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

// Load panels/sections/controls.
require_once bigbox_get_integration( 'woocommerce' )->get_dir() . '/customize/controls/navbar.php';
require_once bigbox_get_integration( 'woocommerce' )->get_dir() . '/customize/controls/store-notice.php';
require_once bigbox_get_integration( 'woocommerce' )->get_dir() . '/customize/controls/store-layout.php';
require_once bigbox_get_integration( 'woocommerce' )->get_dir() . '/customize/controls/placeholders.php';

// Output.
require_once bigbox_get_integration( 'woocommerce' )->get_dir() . '/customize/output/store-notice.php';

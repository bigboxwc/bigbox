<?php
/**
 * Do not modify this file.
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

// Current version -- automatically updated on release.
define( 'BIGBOX_VERSION', '%BIGBOX_VERSION%' );

// Compatibility check.
require_once __DIR__ . '/bootstrap/compatibility-check.php';

// Composer autoloader.
require_once __DIR__ . '/bootstrap/autoload.php';

// Custom template loader.
require_once __DIR__ . '/bootstrap/template-loader.php';

// Start things.
require_once __DIR__ . '/bootstrap/app.php';

<?php
/**
 * Include Composer's autoloader.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Bootstrap
 * @author Spencer Finnell
 */

$file = __DIR__ . '/../vendor/autoload.php';

if ( file_exists( $file ) ) {
	require $file;
}

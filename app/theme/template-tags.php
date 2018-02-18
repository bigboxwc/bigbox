<?php
/**
 * Template tag helpers.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Return the current version of the parent theme.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_get_theme_version() {
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		return time();
	}

	$version = wp_get_theme()->Version;

	if ( wp_get_theme()->parent() ) {
		$version = wp_get_theme()->parent()->Version;
	}

	return $version;
}

/**
 * Determine if an integration is active.
 *
 * @since 1.0.0
 *
 * @param string $integration Integration to check.
 * @return bool
 */
function bigbox_is_integration_active( $integration ) {
	$integrations = new BigBox\Integrations();

	return $integrations
		->instantiate_integration( $integrations->get_integrations()[ $integration ] )
		->is_active();
}

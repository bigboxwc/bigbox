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
 * Return the theme slug.
 *
 * This is static and not derivated from style.css
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_get_theme_name() {
	return 'bigbox';
}

/**
 * Return the current version of the parent theme.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_get_theme_version() {
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || ! defined( 'BIGBOX_VERSION' ) ) {
		return time();
	}

	return BIGBOX_VERSION;
}

/**
 * Get an integration.
 *
 * @since 1.0.0
 *
 * @param string $integration Integration to check.
 * @return mixed False when no integration can be found or Integration instance.
 */
function bigbox_get_integration( $integration ) {
	$integrations = new BigBox\Integrations();
	$integration  = $integrations->get_integrations()[ $integration ];

	if ( ! $integration ) {
		return false;
	}

	return $integrations->instantiate_integration( $integration );
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
	$integration = bigbox_get_integration( $integration );

	if ( ! $integration ) {
		return false;
	}

	return $integration->is_active();
}

/**
 * Return the source (mod setting) for the navbar inputs.
 *
 * @since 1.0.0
 *
 * @param string $source  Source to get.
 * @param string $default Default source.
 * @return string
 */
function bigbox_get_navbar_search_source( $source, $default ) {
	$mod = get_theme_mod( ( 'navbar-source-' . $source ), $default );

	/**
	 * Filters source used for a navbar search input.
	 *
	 * @since 1.0.0
	 *
	 * @param string $mod     The current mod value.
	 * @param string $source  Source to get.
	 * @param string $default Default source.
	 */
	return apply_filters( 'navbar_dropdown_search_source', $mod, $source, $default );
}

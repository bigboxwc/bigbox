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

/**
 * Build HTML star output.
 *
 * @since 1.14.0
 *
 * @param int $rating Rating out of 5 used to generate stars.
 * @return string
 */
function bigbox_get_star_html( $rating ) {
	$full_stars  = floor( $rating );
	$half_stars  = ceil( $rating - floor( $rating ) );
	$empty_stars = 5 - floor( $rating ) - ceil( $rating - floor( $rating ) );

	/* translators: %1$s Rating value. */
	$title = __( '%1$s stars average rating', 'bigbox' );

	$markup = '<span class="star-rating__stars" aria-label="' . esc_attr( sprintf( $title, $rating ) ) . '">';

	// @codingStandardsIgnoreStart
	$markup .= str_repeat( bigbox_get_svg( 'star' ), $full_stars );
	$markup .= str_repeat( bigbox_get_svg( 'star-half' ), $half_stars );
	$markup .= str_repeat( bigbox_get_svg( 'star-empty' ), $empty_stars );
	// @codingStandardsIgnoreEnd
	
	$markup .= '</span>';

	return $markup;
}

<?php
/**
 * Adjust WordPress core template file loader locations.
 *
 * Changes:
 *  `/wp-content/themes/bigbox/single.php`
 * to:
 *  `/wp-content/themes/bigbox/resources/views/single.php`
 *
 * For a child theme to override the file:
 *   `/wp-content/themes/bigbox/resources/views/global/header.php`
 * create the file:
 *   `/wp-content/themes/bigbox-child/global/header.php`
 *
 * or
 *
 *   `/wp-content/themes/bigbox/resources/views/single.php`
 * create the file:
 *   `/wp-content/themes/bigbox-child/single.php`
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

// @see wp-includes/template.php line 41.
$types = [
	'index',
	'404',
	'archive',
	'author',
	'category',
	'tag',
	'taxonomy',
	'date',
	'embed',
	'home',
	'frontpage',
	'page',
	'paged',
	'search',
	'single',
	'singular',
	'attachment',
];

foreach ( $types as $type ) {

	/**
	 * Filter the template hierarchy.
	 *
	 * Required to do this now instead of `{$type}_template` later because
	 * this does not happen until after `locate_template()` is run, which will fail
	 * if the path is not adjusted.
	 *
	 * @since 1.0.0
	 *
	 * @param array $templates The current templates being looked for.
	 * @return array $templates The adjusted template directories.
	 */
	add_filter(
		"{$type}_template_hierarchy", function( $templates ) {
			$_templates = [];

			foreach ( $templates as $k => $template ) {
				// Skip the parent theme's /index.php which is required to be a valid theme.
				if ( ! wp_get_theme()->parent() && 'index.php' === $template ) {
					unset( $templates[ $k ] );
				} elseif ( wp_get_theme()->parent() && 'index.php' === $template && ! file_exists( get_stylesheet_directory() . '/index.php' ) ) {  // Skip the child's /index.php only if it does not exist.
					unset( $templates[ $k ] );
				}

				$_templates[] = 'resources/views/layout/' . $template;
			}

			// Merge with original. This allows child themes to avoid /resources/views/ structure.
			$templates = array_merge( $templates, $_templates );

			return $templates;
		}
	);

} // End foreach().

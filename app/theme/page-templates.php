<?php
/**
 * Manage page templates.
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
 * Filter returned page templates.
 *
 * WordPress will only look in one level of directories by default.
 *
 * Since we know where our page templates are, and that they are only
 * for pages, we can manually add them.
 *
 * @since 1.0.0
 *
 * @param array $page_templates The current list of templates.
 */
function bigbox_page_templates( $page_templates ) {
	return $page_templates;
}
add_filter( 'theme_page_templates', 'bigbox_page_templates' );

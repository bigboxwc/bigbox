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
	$page_templates['resources/views/layout/narrow.php'] = esc_html__( 'Narrow-width', 'bigbox' );
	$page_templates['resources/views/layout/minimal.php'] = esc_html__( 'Minimal', 'bigbox' );
	$page_templates['resources/views/layout/minimal-5.php'] = esc_html__( 'Minimal (Narrow-width)', 'bigbox' );

	return $page_templates;
}
add_filter( 'theme_page_templates', 'bigbox_page_templates' );

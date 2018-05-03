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
	// Translators: Page template name.
	$page_templates['resources/views/layout/narrow.php']    = esc_html__( 'Narrow (10 columns)', 'bigbox' );
	// Translators: Page template name.
	$page_templates['resources/views/layout/minimal.php']   = esc_html__( 'Minimal (10 columns)', 'bigbox' );
	// Translators: Page template name.
	$page_templates['resources/views/layout/minimal-8.php'] = esc_html__( 'Minimal (8 columns)', 'bigbox' );
	// Translators: Page template name.
	$page_templates['resources/views/layout/minimal-5.php'] = esc_html__( 'Minimal (5 columns)', 'bigbox' );

	return $page_templates;
}
add_filter( 'theme_page_templates', 'bigbox_page_templates' );

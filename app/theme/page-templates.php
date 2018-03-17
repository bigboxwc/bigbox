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
 * @param array    $post_templates The current list of templates.
 * @param WP_Theme $theme The current WordPress theme.
 * @param WP_Post  $post the current post object.
 * @param string   $post_type The current post type.
 */
function bigbox_page_templates( $post_templates, $theme, $post, $post_type ) {
	if ( bigbox_is_integration_active( 'woocommerce' ) ) {
		$post_templates['resources/views/layout/shop-home.php'] = esc_html__( 'Homepage', 'bigbox' );
	}

	return $post_templates;
}
add_filter( 'theme_page_templates', 'bigbox_page_templates', 10, 4 );

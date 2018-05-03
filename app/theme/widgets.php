<?php
/**
 * WordPress widget areas.
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
 * Return a (potentially cached) dynamic sidebar.
 *
 * @since 1.0.0
 *
 * @param string $sidebar Sidebar name.
 * @return mixed False for inactive sidebar or string of HTML.
 */
function bigbox_get_dynamic_sidebar( $sidebar ) {
	if ( ! is_active_sidebar( 'shop' ) ) {
		return false;
	}

	$content = wp_cache_get( $sidebar, 'bigbox-sidebar' );

	if ( false !== $content ) {
		return $content;
	}

	ob_start();
	dynamic_sidebar( $sidebar );
	$content = ob_get_clean();

	/**
	 * Filters how long dynamic sidebars are stored in the object cache.
	 *
	 * @since 1.0.0
	 *
	 * @param int             The number of seconds to store the output.
	 * @param string $sidebar The ID of the sidebar being stored.
	 */
	wp_cache_set( $sidebar, $content, 'bigbox-sidebar', apply_filters( 'bigbox_dynamic_sidebar_cache', 60 * MINUTE_IN_SECONDS, $sidebar ) );

	return $content;
}

/**
 * Register widgetized areas.
 *
 * @since 1.0.0
 */
function bigbox_register_sidebars() {
	$count = bigbox_get_footer_nav_columns();

	// Footer widgets.
	for ( $i = 1; $i <= $count; $i++ ) {
		register_sidebar(
			[
				// Translators: Widget column number.
				'name'          => sprintf( __( 'Footer Navigation Column %d', 'bigbox' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => '',
				'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title footer-widget__title">',
				'after_title'   => '</h4>',
			]
		);
	}
}
add_action( 'widgets_init', 'bigbox_register_sidebars' );

/**
 * Get the number of columns for the footer.
 *
 * @since 1.0.0
 *
 * @return int
 */
function bigbox_get_footer_nav_columns() {
	/**
	 * Adjust the number of footer widget columns.
	 *
	 * @since 1.0.0
	 *
	 * @param int The number of columns to generate.
	 */
	return apply_filters( 'bigbox_footer_widget_columns', 5 );
}

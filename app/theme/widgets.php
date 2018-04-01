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
 * Register widgetized areas.
 *
 * @since 1.0.0
 */
function bigbox_register_sidebars() {
	$count = bigbox_get_footer_nav_columns();

	// Footer widgets.
	for ( $i = 1; $i <= $count; $i++ ) {
		register_sidebar(
			array(
				// Translators: Widget column number.
				'name'          => sprintf( __( 'Footer Navigation Column %d', 'bigbox' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => '',
				'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title footer-widget__title">',
				'after_title'   => '</h4>',
			)
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
	return apply_filters( 'bigbox_footer_widget_columns', 5 );
}

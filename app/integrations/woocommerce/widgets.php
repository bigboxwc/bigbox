<?php
/**
 * WooCommerce widget functionality.
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
function bigbox_woocommerce_register_sidebars() {
	register_sidebar(
		[
			// Translators: Widget area name.
			'name'          => __( 'Shop Sidebar (Left)', 'bigbox' ),
			'id'            => 'shop',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		]
	);

	register_sidebar(
		[
			// Translators: Widget area name.
			'name'          => __( 'Shop Sidebar (Right)', 'bigbox' ),
			'id'            => 'shop-tertiary',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		]
	);

	register_sidebar(
		[
			// Translators: Widget area name.
			'name'          => __( 'Shop Sidebar (Comments)', 'bigbox' ),
			'id'            => 'shop-comments',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		]
	);
}
add_action( 'widgets_init', 'bigbox_woocommerce_register_sidebars' );

/**
 * Default arguments for shop sidebar widgets.
 *
 * Helpful when outputting sstatic widgets.
 *
 * @since 1.0.0
 *
 * @param array $args Arguments to make classes a bit more dynamic.
 */
function bigbox_woocommerce_shop_sidebar_args( $args = [] ) {
	$default = [
		'id'    => null,
		'class' => null,
	];

	$args = wp_parse_args( $args, $default );

	return [
		'before_widget' => sprintf( '<div id="%1$s" class="widget %2$s">', $args['id'], $args['class'] ),
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	];
}

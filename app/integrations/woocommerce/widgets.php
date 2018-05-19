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
 * Output default WooCommerce widgets if the left sidebar is blank.
 *
 * @since 1.0.0
 *
 * @param string $content Sidebar HTML content.
 * @return string
 */
function bigbox_woocommerce_dynamic_sidebar_shop( $content ) {
	// Don't fill if not needed.
	if ( '' !== $content ) {
		return $content;
	}

	if ( (bool) get_theme_mod( 'hide-shop-sidebar', false ) ) {
		return $content;
	}

	ob_start();

	// Price filter.
	the_widget(
		'WC_Widget_Price_Filter',
		[
			'title' => 'Filter by price',
		],
		bigbox_woocommerce_shop_sidebar_args(
			[
				'id'    => 'woocommerce_price_filter',
				'class' => 'woocommerce widget_price_filter',
			]
		)
	);

	// Color filter. Assumes testing with default content import.
	the_widget(
		'WC_Widget_Layered_Nav',
		[
			'title'     => 'Filter by color',
			'attribute' => 'color',
		],
		bigbox_woocommerce_shop_sidebar_args(
			[
				'id'    => 'woocommerce_layered_nav',
				'class' => 'woocommerce widget_layered_nav woocommerce-widget-layered-nav',
			]
		)
	);

	return ob_get_clean();
}
add_filter( 'bigbox_dynamic_sidebar_shop', 'bigbox_woocommerce_dynamic_sidebar_shop' );

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

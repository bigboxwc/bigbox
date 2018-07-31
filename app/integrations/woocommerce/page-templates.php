<?php
/**
 * WooCommerce page templates.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Auto apply page templates to assigned WooCommerce pages.
 *
 * @since 1.0.0
 *
 * @param array $templates The current list of templates.
 * @return array
 */
function bigbox_woocommerce_assign_page_templates( $templates ) {
	$add = [];
	$no_template = '' === get_page_template_slug();

	if ( is_cart() && $no_template ) {
		$add[] = bigbox_woocommerce_template_path() . 'cart.php';
	}

	if ( is_checkout() && ! is_order_received_page() && $no_template ) {
		$add[] = 'resources/views/layout/minimal.php';
	}

	if ( is_account_page() && ! is_user_logged_in() && $no_template ) {
		if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
			$add[] = 'resources/views/layout/minimal.php';
		} else {
			$add[] = 'resources/views/layout/minimal-5.php';
		}
	} elseif ( is_account_page() && is_user_logged_in() && $no_template ) {
		$add[] = 'resources/views/layout/narrow.php';
	}

	if ( is_order_received_page() && $no_template ) {
		$add[] = 'resources/views/layout/narrow.php';
	}

	if ( ! empty( $add ) ) {
		$templates = array_merge( $add, $templates );
	}

	return $templates;
}
add_filter( 'page_template_hierarchy', 'bigbox_woocommerce_assign_page_templates', 5 );


/**
 * Return the page template name for dynamic shops.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_woocommerce_dynamic_shop_page_template() {
	/**
	 * Filters the name (path) of the template name used for dynamic shop pages.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name The name (including path from theme root) of the template file.
	 */
	return apply_filters(
		'bigbox_woocommerce_dynamic_shop_page_template',
		bigbox_woocommerce_template_path() . 'archive-product-page.php'
	);
}

/**
 * Filter returned page templates.
 *
 * @since 1.0.0
 *
 * @param array $page_templates The current list of templates.
 */
function bigbox_woocommmerce_page_templates( $page_templates ) {
	/* translators: Page template name. */
	$page_templates[ bigbox_woocommerce_dynamic_shop_page_template() ] = __( 'Shop', 'bigbox' );

	return $page_templates;
}
add_filter( 'theme_page_templates', 'bigbox_woocommmerce_page_templates' );

/**
 * Delete transient when an object saves.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_reset_dynamic_shop_pages() {
	delete_transient( 'bigbox-dynamic-shop-pages' );
}
add_action( 'save_post', 'bigbox_woocommerce_reset_dynamic_shop_pages' );

/**
 * Get pages assigned to use a dynamic sidebar.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_woocommerce_get_dynamic_shop_pages() {
	$pages = get_transient( 'bigbox-dynamic-shop-pages' );

	if ( false === $pages ) {
		$pages = [];

		// @codingStandardsIgnoreStart
		$query = new WP_Query(
			[
				'fields'                 => 'ids',
				'nopaging'               => true,
				'post_type'              => 'page',
				'update_post_meta_cache' => false,
				'update_term_meta_cache' => false,
				'meta_query'             => [
					[
						'key'     => '_wp_page_template',
						'value'   => bigbox_woocommerce_template_path() . 'archive-product-page.php',
						'compare' => '=',
					],
				],
			]
		);
		// @codingStandardsIgnoreEnd

		if ( ! empty( $query->posts ) ) {
			$pages = $query->posts;
		}

		set_transient( 'bigbox-dynamic-sidebar-pages', $pages );
	}

	return $pages;
}

/**
 * Register dynamic widget areas.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_dynamic_shop_pages_create_sidebars() {
	$pages = bigbox_woocommerce_get_dynamic_shop_pages();

	if ( empty( $pages ) ) {
		return;
	}

	foreach ( $pages as $page ) {
		$woocommerce_dynamic_shop_page_widget_args = [
			/* translators: %s: Dynamic widget area name. */
			'name'          => sprintf( __( 'Page: %s', 'bigbox' ), get_the_title( $page ) ),
			/* translators: %s: Dynamic widget area description. */
			'description'   => sprintf( __( 'Widgets that appear on the "%s" page.', 'bigbox' ), get_the_title( $page ) ),
			'id'            => 'page-' . $page,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		];

		register_sidebar(
			/**
			 * Filters the argument used when registering sidebars for dynamic shop pages.
			 *
			 * @since 1.0.0
			 *
			 * @param array $args The arguments used in register_sidebar()
			 */
			apply_filters(
				'bigbox_woocommerce_dynamic_shop_pages_widget_args',
				$woocommerce_dynamic_shop_page_widget_args,
				$page
			)
		);
	}
}
add_action( 'widgets_init', 'bigbox_woocommerce_dynamic_shop_pages_create_sidebars' );

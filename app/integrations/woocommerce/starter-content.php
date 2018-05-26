<?php
/**
 * Starter content.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */

/**
 * Filter the starter content.
 *
 * @since 1.0.0
 *
 * @param array $content Starter content.
 * @return array $content Starter content.
 */
function bigbox_woocommerce_get_starter_content( $content ) {
	$products = bigbox_woocommerce_get_starter_content_products();
	$pages    = bigbox_woocommerce_get_starter_content_pages();

	// Add products.
	$content['posts'] = array_merge( $content['posts'], $products );

	// Add pages.
	$content['posts'] = array_merge( $content['posts'], $pages );

	// Update options
	$content['options']['page_on_front'] = '{{shop}}';

	return $content;
}
add_filter( 'bigbox_get_starter_content', 'bigbox_woocommerce_get_starter_content' );

/**
 * Get products to add to starter content.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_woocommerce_get_starter_content_products() {
	return [
		'beanie' => array(
			'post_title'     => esc_attr__( 'Beanie', 'storefront' ),
			'post_content'   => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
			'post_type'      => 'product',
			'comment_status' => 'open',
			'thumbnail'      => '{{beanie-image}}',
			'product_data'   => array(
				'regular_price' => '20',
				'price'         => '18',
				'sale_price'    => '18',
				'featured'      => false,
			),
			// 'taxonomy' => array(
			// 	'product_cat' => array(
			// 		array(
			// 			'term'        => $accessories_name,
			// 			'slug'        => 'accessories',
			// 			'description' => $accessories_description,
			// 		),
			// 	),
			// ),
		),
	];
}

/**
 * Get pages to add to starter content.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_woocommerce_get_starter_content_pages() {
	$pages = [];

	$wc_pages_options = [
		'woocommerce_cart_page_id',
		'woocommerce_checkout_page_id',
		'woocommerce_myaccount_page_id',
		'woocommerce_shop_page_id',
		'woocommerce_terms_page_id'
	];

	foreach ( $wc_pages_options as $option ) {
		$page_id = get_option( $option );

		if ( ! empty( $page_id ) ) {
			$page_id = intval( $page_id );
			$page    = get_post( $page_id );

			$pages[ $page->post_name ] = [
				'post_title' => $page->post_title,
				'post_name'  => $page->post_name,
				'post_type'  => 'page',
			];
		}
	}

	return $pages;
}

/**
 * Filter WooCommerce queries to include starter content.
 *
 * @since 1.0.0
 *
 * @param WP_Query $query WordPress query.
 */
function bigbox_woocommerce_starter_content_wc_query( $query ) {
	$post__in = array();

	// Add existing products.
	$existing_products = bigbox_woocommerce_starter_get_existing_wc_products();

	if ( ! empty( $existing_products ) ) {
		$post__in = array_merge( $post__in, $existing_products );
	}

	// Add starter content.
	$created_products = bigbox_woocommerce_starter_get_created_starter_content_products();

	if ( false !== $created_products ) {

		// Merge starter content products.
		$post__in = array_merge( $post__in, $created_products );

		// Allow for multiple status.
		$query->set( 'post_status', get_post_stati() );
	}

	// Add products to query.
	$query->set( 'post__in', $post__in );
}
if ( is_customize_preview() ) {
	add_action( 'woocommerce_product_query', 'bigbox_woocommerce_starter_content_wc_query' );
}

/**
 * Filter shortcode products loop in WooCommerce.
 *
 * @since 1.0.0
 *
 * @param array  $query_args Query args.
 * @param array  $atts Shortcode attributes.
 * @param string $loop_name Loop name.
 * @return array $args
 */
function bigbox_woocommerce_starter_content_shortcode_loop_products( $query_args, $atts, $loop_name = null ) {
	$query_args['post__in'] = array();

	// Add existing products to query
	$existing_products = bigbox_woocommerce_starter_get_existing_wc_products();

	if ( ! empty( $existing_products ) ) {
		$query_args['post__in'] = array_merge( $query_args['post__in'], $existing_products );
	}

	// Add starter content to query
	$created_products = bigbox_woocommerce_starter_get_created_starter_content_products();

	if ( false !== $created_products ) {

		// Add created products to query.
		$query_args['post__in'] = array_merge( $query_args['post__in'], $created_products );

		// Allow for multiple status.
		$query_args['post_status'] = get_post_stati();
	}

	return $query_args;
}
if ( is_customize_preview() ) {
	add_filter( 'woocommerce_shortcode_products_query', 'bigbox_woocommerce_starter_content_shortcode_loop_products', 10, 3 );
}

/**
 * Get a list of posts created by starter content.
 *
 * @since 1.0.0
 *
 * @return mixed false|rray $query Array of post ids.
 */
function bigbox_woocommerce_starter_get_created_starter_content_products() {
	global $wp_customize;

	$data                 = $wp_customize->get_setting( 'nav_menus_created_posts' );
	$created_products_ids = $data->value();

	if ( ! empty( $created_products_ids ) ) {
		return (array) $created_products_ids;
	}

	return false;
}

/**
 * Get a list of existing products in the store.
 *
 * @since 1.0.0
 *
 * @return array $query Array of product ids.
 */
function bigbox_woocommerce_starter_get_existing_wc_products() {
	$query_args = [
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'fields'         => 'ids',
		'posts_per_page' => -1,
	];

	$products = get_posts( $query_args );

	if ( $products && ! empty( $products ) ) {
		return $products;
	}

	return [];
}

/**
 * WooCommerce 3.0.0 changes the title of all auto-draft products to "AUTO-DRAFT".
 * Here we change the title back when the post status changes.
 *
 * @since 1.0.0
 *
 * @param string $new_status New status.
 * @param string $old_status Old status.
 * @param object $post
 */
function bigbox_woocommerce_starter_content_transition_post_status( $new_status, $old_status, $post ) {
	if ( 'publish' === $new_status && 'auto-draft' === $old_status && in_array( $post->post_type, [ 'product' ] ) ) {
		$post_name = get_post_meta( $post->ID, '_customize_draft_post_name', true );

		$starter_products = bigbox_woocommerce_get_starter_content_products();

		if ( $post_name && array_key_exists( $post_name, $starter_products ) ) {
			$update_product = [
				'ID'         => $post->ID,
				'post_title' => $starter_products[ $post_name ]['post_title']
			];

			wp_update_post( $update_product );
		}
	}
}
add_action( 'transition_post_status', 'bigbox_woocommerce_starter_content_transition_post_status', 10, 3 );

/**
 * WooCommerce 3.0.0 changes the title of all auto-draft products to "AUTO-DRAFT".
 * Here we filter the title and display the correct one instead.
 *
 * @since 1.0.0
 *
 * @param string $title Post title.
 * @param int $post_id Post ID.
 */
function bigbox_woocommerce_starter_content_the_title( $title, $post_id = null ) {
	if ( ! $post_id ) {
		return $title;
	}

	$post = get_post( $post_id );

	if ( $post && 'auto-draft' === $post->post_status && in_array( $post->post_type, [ 'product' ] ) && 'AUTO-DRAFT' === $post->post_title ) {
		$post_name = get_post_meta( $post->ID, '_customize_draft_post_name', true );

		$starter_products = bigbox_woocommerce_get_starter_content_products();

		if ( $post_name && array_key_exists( $post_name, $starter_products ) ) {
			return $starter_products[ $post_name ]['post_title'];
		}
	}

	return $title;
}
add_filter( 'the_title', 'bigbox_woocommerce_starter_content_the_title', 10, 2 );

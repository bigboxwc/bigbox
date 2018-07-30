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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Filter the starter content.
 *
 * @since 1.0.0
 *
 * @param array $content Starter content.
 * @return array $content Starter content.
 */
function bigbox_woocommerce_get_starter_content( $content ) {
	// Add data.
	$content['attachments'] = bigbox_woocommerce_get_starter_content_attachments();
	$content['posts']       = array_merge( $content['posts'], bigbox_woocommerce_get_starter_content_products() );
	$content['posts']       = array_merge( $content['posts'], bigbox_woocommerce_get_starter_content_pages() );

	// Update options.
	$content['options']['page_on_front']                 = '{{shop}}';
	$content['options']['woocommerce_shop_page_display'] = 'both';

	// Add widgets.
	$content['widgets'] = [
		'shop' => [
			'woocommerce_product_categories' => [
				'woocommerce_product_categories',
				[
					'title' => __( 'Categories', 'bigbox' ),
				],
			],
		],
	];

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
	$integration = bigbox_get_integration( 'woocommerce' );

	$products = require $integration->get_dir() . '/starter-content/products.php';

	// Set key as `post_name`.
	foreach ( $products as $key => $product ) {
		$products[ $key ]['post_name'] = $key;
	}

	return $products;
}

/**
 * Get attachments to add to starter content.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_woocommerce_get_starter_content_attachments() {
	$integration = bigbox_get_integration( 'woocommerce' );

	return require $integration->get_dir() . '/starter-content/attachments.php';
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
		'woocommerce_terms_page_id',
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
	$post__in = [];

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
	$query_args['post__in'] = [];

	// Add existing products to query.
	$existing_products = bigbox_woocommerce_starter_get_existing_wc_products();

	if ( ! empty( $existing_products ) ) {
		$query_args['post__in'] = array_merge( $query_args['post__in'], $existing_products );
	}

	// Add starter content to query.
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
	// @codingStandardsIgnoreStart
	$products = get_posts( [
		'post_type'        => 'product',
		'post_status'      => 'publish',
		'fields'           => 'ids',
		'posts_per_page'   => -1,
		'suppress_filters' => false,
	] );
	// @codingStandardsIgnoreEnd

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
 * @param object $post Post object.
 */
function bigbox_woocommerce_starter_content_transition_post_status( $new_status, $old_status, $post ) {
	if ( 'publish' === $new_status && 'auto-draft' === $old_status && in_array( $post->post_type, [ 'product' ], true ) ) {
		$post_name = get_post_meta( $post->ID, '_customize_draft_post_name', true );

		$starter_products = bigbox_woocommerce_get_starter_content_products();

		if ( $post_name && array_key_exists( $post_name, $starter_products ) ) {
			$update_product = [
				'ID'         => $post->ID,
				'post_title' => $starter_products[ $post_name ]['post_title'],
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
 * @param int    $post_id Post ID.
 */
function bigbox_woocommerce_starter_content_the_title( $title, $post_id = null ) {
	if ( ! $post_id ) {
		return $title;
	}

	$post = get_post( $post_id );

	if ( $post && 'auto-draft' === $post->post_status && in_array( $post->post_type, [ 'product' ], true ) && 'AUTO-DRAFT' === $post->post_title ) {
		$post_name = get_post_meta( $post->ID, '_customize_draft_post_name', true );

		$starter_products = bigbox_woocommerce_get_starter_content_products();

		if ( $post_name && array_key_exists( $post_name, $starter_products ) ) {
			return $starter_products[ $post_name ]['post_title'];
		}
	}

	return $title;
}
if ( is_customize_preview() ) {
	add_filter( 'the_title', 'bigbox_woocommerce_starter_content_the_title', 10, 2 );
}

/**
 * Add a taxonomy (category, tag) to a product.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_starter_content_add_product_tax() {
	$created_products = bigbox_woocommerce_starter_get_created_starter_content_products();

	if ( false === $created_products ) {
		return;
	}

	$starter_products = bigbox_woocommerce_get_starter_content_products();

	if ( is_array( $created_products ) ) {
		foreach ( $created_products as $product ) {
			$product = get_post( $product );

			if ( ! $product ) {
				continue;
			}

			$post_name = get_post_meta( $product->ID, '_customize_draft_post_name', true );

			if ( ! $post_name || ! array_key_exists( $post_name, $starter_products ) ) {
				continue;
			}

			$taxonomies = [ 'product_cat', 'product_tag' ];

			foreach ( $taxonomies as $taxonomy ) {
				if ( array_key_exists( $taxonomy, $starter_products[ $post_name ]['taxonomy'] ) ) {
					$categories = $starter_products[ $post_name ]['taxonomy'][ $taxonomy ];

					if ( ! empty( $categories ) ) {
						$category_ids = [];

						foreach ( $categories as $category ) {
							// Check if the term already exists.
							$category_exists = term_exists( $category['term'], $taxonomy ); // @codingStandardsIgnoreLine

							if ( $category_exists ) {
								$category_ids[] = (int) $category_exists['term_id'];

								continue;
							}

							// Create new category.
							$created_category = wp_insert_term(
								$category['term'],
								$taxonomy,
								[
									'description' => $category['description'],
									'slug'        => $category['slug'],
								]
							);
						}

						wp_set_object_terms( $product->ID, $category_ids, $taxonomy );
					}
				}
			}
		}
	}

	add_filter( 'bigbox_navbar_search_dropdown', 'bigbox_woocommerce_starter_content_filter_categories' );
	add_filter( 'woocommerce_product_subcategories_args', 'bigbox_woocommerce_starter_content_filter_categories' );
	add_filter( 'woocommerce_product_subcategories_hide_empty', '__return_false' );
}
add_action( 'customize_preview_init', 'bigbox_woocommerce_starter_content_add_product_tax' );

/**
 * Add product data to starter products.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_starter_content_set_product_data() {
	$created_products = bigbox_woocommerce_starter_get_created_starter_content_products();

	if ( false === $created_products ) {
		return;
	}

	$starter_products = bigbox_woocommerce_get_starter_content_products();

	if ( is_array( $created_products ) ) {
		foreach ( $created_products as $product ) {
			$product = wc_get_product( $product );

			if ( ! $product ) {
				continue;
			}

			$post_name = get_post_meta( $product->get_id(), '_customize_draft_post_name', true );

			if ( ! $post_name || ! array_key_exists( $post_name, $starter_products ) ) {
				continue;
			}

			if ( ! array_key_exists( 'product_data', $starter_products[ $post_name ] ) ) {
				continue;
			}

			$product_data = $starter_products[ $post_name ]['product_data'];

			// Set visibility.
			$product->set_catalog_visibility( 'visible' );

			// Set regular price.
			if ( ! empty( $product_data['regular_price'] ) ) {
				$product->set_regular_price( floatval( $product_data['regular_price'] ) );
			}

			// Set price.
			if ( ! empty( $product_data['price'] ) ) {
				$product->set_price( floatval( $product_data['price'] ) );
			}

			// Set sale price.
			if ( ! empty( $product_data['sale_price'] ) ) {
				$product->set_sale_price( floatval( $product_data['sale_price'] ) );
			}

			// Set featured.
			if ( ! empty( $product_data['featured'] ) ) {
				$product->set_featured( true );
			} else {
				$product->set_featured( false );
			}

			// Save.
			$product->save();
		}
	}
}
add_action( 'customize_preview_init', 'bigbox_woocommerce_starter_content_set_product_data' );

/**
 * Filter dropdown based on ghost categories.
 *
 * @since 1.0.0
 *
 * @param array $args Drodpown arguments.
 * @return array
 */
function bigbox_woocommerce_starter_content_filter_categories( $args ) {
	// Get Categories.
	$product_cats = get_terms(
		'product_cat',
		[
			'fields'     => 'ids',
			'hide_empty' => false,
		]
	);

	if ( ! empty( $product_cats ) ) {
		$args['hide_empty'] = false;

		$args['ids'] = implode( $product_cats, ',' );
	}

	return $args;
}

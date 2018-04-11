<?php
/**
 * WooCommerce template functions.
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
 * Remove any default styles.
 *
 * @since 1.0.0
 *
 * @param array $styles Style slugs to load.
 * @return array
 */
function bigbox_woocommerce_enqueue_styles( $styles ) {
	unset( $styles['woocommerce-general'] );
	unset( $styles['woocommerce-layout'] );
	unset( $styles['woocommerce-smallscreen'] );

	return $styles;
}

/**
 * Look in the integration for templates.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_woocommerce_template_path() {
	return 'app/integrations/woocommerce/templates/';
}

/**
 * JS settings.
 *
 * @since 1.0.0
 *
 * @param array $settings Javascript settings.
 * @return array
 */
function bigbox_woocommerce_js_settings( $settings ) {
	$settings['products'] = [
		'quantitySelector' => [
			'max' => 30,
		],
	];

	return $settings;
}

/**
 * Adjust the number of columns if the results returned need it.
 *
 * @since 1.0.0
 *
 * @param int $value Option value.
 * @return int
 */
function bigbox_woocommerce_adjust_catalog_columns() {
	$total   = wc_get_loop_prop( 'total' );
	$columns = wc_get_loop_prop( 'columns' );

	// If the total found is fewer than the number of columns show a standard list.
	if ( $total <= absint( $columns ) ) {
		return wc_set_loop_prop( 'columns', $total );
	}
}

/**
 * Load a separate view for the navbar search.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_woocommerce_navbar_search() {
	return wc_get_template( 'global/navbar-search.php' );
}

/**
 * Adjust opening wrapper tag.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_output_content_wrapper() {
	echo '<div id="main" class="site-primary" role="main">';
}

/**
 * Adjust closing wrapper tag.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_output_content_wrapper_end() {
	echo '</div>';
}

/**
 * Shop item loop opening tag.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_before_shop_loop_item() {
	echo '<div class="product__inner">';
}

/**
 * Shop item loop closing tag.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_after_shop_loop_item() {
	echo '</div>';
}

/**
 * Page count and ordering opening tag.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_before_shop_loop() {
	echo '<div class="woocommerce-products-meta">';
}

/**
 * Page count and ordering closing tag.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_before_shop_loop_after() {
	echo '</div>';
}

/**
 * Adjust closing wrapper for categories.
 *
 * Close the opening <ul class="products"> and start a new one.
 *
 * @since 1.0.0
 *
 * @param string $output Category output.
 * @return string
 */
function bigbox_woocommerce_after_output_product_categories( $output ) {
	$product_categories = woocommerce_get_product_subcategories( is_product_category() ? get_queried_object_id() : 0 );
	$total              = count( $product_categories );

	ob_start();

	if ( $total > 5 ) {
		$more_categories = array_slice( $product_categories, 5, $total - 5 );
	}

	if ( ! empty( $more_categories ) || has_nav_menu( 'product-category-list' ) ) {
?>

<li class="product-category product product-category-more">
	<div class="product-category-more__inner">

		<div class="product-category-more__menu">
		<?php
		wp_nav_menu(
			[
				'theme_location' => 'product-category-list',
				'container'      => false,
				'fallback_cb'    => false,
				'depth'          => 1,
			]
		);
		?>
		</div>

		<?php if ( ! empty( $more_categories ) ) : ?>
		<form id="product-category-selector" action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" method="GET" class="product-category-more__selector">
			<select name="product_cat">
				<option><?php echo esc_html_e( 'More...', 'bigbox' ); ?></option>

				<?php foreach ( $more_categories as $category ) : ?>
				<option value="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</form>
		<?php endif; ?>
	</div>
</li>

<?php
	}

	wc_get_template( 'loop/loop-end.php' );

	wc_set_loop_prop( 'products-loop', 'main' );
	wc_get_template( 'loop/loop-start.php' );

	return ob_get_clean();
}

/**
 * Show note for variable products.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_after_shop_loop_item_title_variations() {
	global $product;

	if ( 'variable' !== $product->get_type() ) {
		return;
	}
?>

<div class="product__has-variations product__stats">
	<a href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', $product->get_permalink(), $product ) ); ?>">
		<?php esc_html_e( 'See More Options', 'bigbox' ); ?>
	</a>
</div>

<?php
}

/**
 * Custom purchase form area.
 *
 * @since 1.0.0
 */
function bigbox_purchase_form() {
	$product = wc_get_product( get_post() );

	if ( ! is_singular( 'product' ) || ! $product->is_purchasable() ) {
		return;
	}

	wc_get_template( 'single-product/add-to-cart/purchase-form.php' );
}

/**
 * Modify default tab titles.
 *
 * WooCommerce core doesn't use the actual set titles so instead we can
 * filter the direct strings here.
 *
 * @since 1.0.0
 *
 * @param array $tabs Current tabs.
 * @return array
 */
function bigbox_woocommerce_product_tabs( $tabs ) {
	add_filter(
		'woocommerce_product_description_heading', function() {
			return esc_html__( 'Product description', 'bigbox' );
		}
	);

	add_filter(
		'woocommerce_product_additional_information_heading', function() {
			return esc_html__( 'Product information', 'bigbox' );
		}
	);

	$tabs['upsells'] = [
		'title'    => esc_html__( 'You may also enjoy', 'bigbox' ),
		'priority' => 20,
		'callback' => 'woocommerce_upsell_display',
	];

	$tabs['related'] = [
		'title'    => esc_html__( 'Related products', 'bigbox' ),
		'priority' => 30,
		'callback' => 'woocommerce_output_related_products',
	];

	if ( isset( $tabs['reviews'] ) ) {
		$tabs['reviews']['priority'] = 40;
	}

	return $tabs;
}

/**
 * Maybe display shop attributes.
 *
 * WooCommerce always outputs a blank table which doesn't work well
 * when we globally apply borders to tables.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_display_product_attributes() {
	ob_start();

	wc_display_product_attributes( wc_get_product( get_post() ) );

	$attributes = ob_get_clean();

	if ( '<tableclass="shop_attributes"></table>' !== trim( preg_replace( '/\s/', '', $attributes ) ) ) {
		echo $attributes;
	}
}

/**
 * Add product meta under additional information.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_product_additional_information() {
	$product = wc_get_product( get_post() );

	if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) :
?>

	<p class="sku_wrapper">
		<?php esc_html_e( 'SKU:', 'bigbox' ); ?>
		<span class="sku"><?php echo esc_html( ( $product->get_sku() ) ? $product->get_sku() : __( 'N/A', 'bigbox' ) ); ?></span>
	</p>

<?php
	endif;

	// @codingStandardsIgnoreStart
	echo wc_get_product_category_list( $product->get_id(), ', ', '<p class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'bigbox' ) . ' ', '</p>' );

	echo wc_get_product_tag_list( $product->get_id(), ', ', '<p class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'bigbox' ) . ' ', '</p>' );
	// @codingStandardsIgnoreEnd
}

/**
 * Adjust rating output to use star icons.
 *
 * @since 1.0.0
 *
 * @param string $html   Current HTML.
 * @param float  $rating Rating to be shown.
 * @param int    $count  Total number of ratings.
 * @return string
 */
function bigbox_woocommerce_get_star_rating_html( $html, $rating, $count ) {
	$full_stars  = floor( $rating );
	$half_stars  = ceil( $rating - floor( $rating ) );
	$empty_stars = 5 - floor( $rating ) - ceil( $rating - floor( $rating ) );

	// Translators: %1$s Rating value.
	$title = __( '%1$s average rating', 'bigbox' );

	// Translators: %1$s Number of ratings.
	$count_title = __( '%1$s customer ratings', 'bigbox' );

	ob_start();
?>

<span class="star-rating__stars" aria-title="<?php esc_attr( sprintf( $title, $rating ) ); ?>">
	<?php
	// @codingStandardsIgnoreStart
	echo str_repeat( bigbox_get_svg( 'star' ), $full_stars );
	echo str_repeat( bigbox_get_svg( 'star-half' ), $half_stars );
	echo str_repeat( bigbox_get_svg( 'star-empty' ), $empty_stars );
	// @codingStandardsIgnoreEnd
	?>
</span>

<?php if ( 0 !== $count && ! is_singular( 'product' ) ) : ?>

	<span class="star-rating__count" aria-title="<?php esc_attr( sprintf( $count_title, $count ) ); ?>">
		<?php echo esc_html( $count ); ?>
	</span>

<?php endif; ?>

<?php
	return ob_get_clean();
}

/**
 * Breadcrumb arguments.
 *
 * @since 1.0.0
 *
 * @param array $args Arugments.
 * @return array
 */
function bigbox_woocommerce_breadcrumb_defaults( $args ) {
	$args['delimiter'] = '&nbsp&nbsp;&#8250;&nbsp;&nbsp';

	return $args;
}

/**
 * Pagination arguments.
 *
 * @since 1.0.0
 *
 * @param array $args Arguments.
 * @return array
 */
function bigbox_woocommerce_pagination_args( $args ) {
	$args['prev_text'] = bigbox_get_svg( array( 'icon' => 'arrow-left' ) ) . esc_html__( 'Previous Page', 'bigbox' );
	$args['next_text'] = esc_html__( 'Next Page', 'bigbox' ) . bigbox_get_svg( array( 'icon' => 'arrow-right' ) );

	return $args;
}

/**
 * Modify Flexlider gallery output.
 *
 * @since 1.0.0
 *
 * @param array $args Flexslider arguments.
 * @return array
 */
function bigbox_woocommerce_single_product_carousel_options( $args ) {
	$args['directionNav'] = true;

	$args['nextText'] = bigbox_get_svg(
		[
			'title' => __( 'Next', 'bigbox' ),
			'icon'  => 'arrow-right',
		]
	);

	$args['prevText'] = bigbox_get_svg(
		[
			'title' => __( 'Previous', 'bigbox' ),
			'icon'  => 'arrow-left',
		]
	);

	return $args;
}

/**
 * Output markup for mobile shop filter toggles.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_archive_mobile_filters() {
	wc_get_template( 'loop/shop-filters-mobile.php' );
}

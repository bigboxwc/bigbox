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
 * WooCommerce specific scripts.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_wp_enqueue_scripts() {
	$version    = bigbox_get_theme_version();
	$stylesheet = bigbox_get_theme_name();

	$deps = [
		$stylesheet,
		'wp-util',
		'jquery-blockui',
	];

	wp_enqueue_script( "{$stylesheet}-woocommerce", get_template_directory_uri() . '/public/js/woocommerce.min.js', $deps, $version, true );

	if ( ! is_cart() || is_checkout() ) {
		wp_dequeue_script( 'wc-cart-fragments' );
	}
}

/**
 * Ensure cart fragments script is enqueued when cart widget is used.
 *
 * @since 1.0.0
 *
 * @param bool $hidden Is the cart widget hidden.
 * @return bool
 */
function bigbox_woocommerce_widget_cart_is_hidden( $hidden ) {
	wp_enqueue_script( 'wc-cart-fragments' );

	return $hidden;
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
	$settings['woocommerce']['products'] = [
		'quantitySelector' => [
			'zero'      => trim( 0 . ' ' . ( ! is_singular( 'product' ) ? esc_html__( '(remove)', 'bigbox' ) : null ) ),
			/**
			 * Filters the maximum number of products that can be added at one time.
			 *
			 * @since 1.0.0
			 *
			 * @param int $max The maximum number that can be used at one time.
			 */
			'globalMax' => apply_filters(
				'bigbox_woocommerce_quantity_selector_max',
				30
			),
		],
	];

	return $settings;
}

/**
 * Determine if we are on a shop page.
 *
 * By default this checks for:
 *
 * - WooCommerce shop page.
 * - Dynamic shop page template.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function bigbox_is_shop() {
	/**
	 * Filters a conditional to determine if the current page is a shop.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $is_shop If the current page should be considered a shop.
	 */
	return apply_filters(
		'bigbox_is_shop',
		(
			( is_shop() || is_product_taxonomy() )
			|| is_page_template( bigbox_woocommerce_dynamic_shop_page_template() )
		)
	);
}

/**
 * Determine if a WooCommerce thumbnail should display.
 *
 * @since 1.0.0
 *
 * @param WC_Product $product WooCommerce product. Attempts to find global if null.
 * @return mixed String of HTML for an image or null.
 */
function bigbox_woocommerce_has_product_image( $product = null ) {
	if ( ! $product ) {
		$product = wc_get_product( get_the_ID() );
	}

	if ( get_theme_mod( 'hide-image-placeholders', false ) ) {
		return '' !== $product->get_image_id();
	}

	return '' !== $product->get_image();
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
 * Shop item loop opening tag.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_before_shop_loop_item() {
	echo '<div class="product__inner">';
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
 * Wrap single product summary inside.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_single_product_summary_inner() {
	echo '<div class="summary__inner">';
}

/**
 * Close an open div.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_template_close_div() {
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

		<?php if ( has_nav_menu( 'product-category-list' ) ) : ?>
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
		<?php endif; ?>

		<?php
		/**
		 * Filters if the product categories dropdown should be shown.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $show Should the dropdown show?
		 */
		if ( ! empty( $more_categories ) && apply_filters( 'bigbox_woocommerce_after_output_product_categories_dropdown', true ) ) :
		?>
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
 * Order subcategory output by count.
 *
 * @since 1.0.0
 *
 * @param array $args Args to control output.
 * @return array
 */
function bigbox_woocommerce_product_subcategories_args( $args ) {
	$args['orderby'] = 'count';

	return $args;
}

/**
 * Show note for variable products.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_template_loop_variations() {
	$product = wc_get_product( get_the_ID() );

	if ( ! $product->is_in_stock() ) {
		 return;
	}

	if ( 'variable' !== $product->get_type() ) {
		return;
	}
?>

<div class="product__has-variations product__meta">
	<a href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', $product->get_permalink(), $product ) ); ?>">
		<?php esc_html_e( 'See More Options', 'bigbox' ); ?>
	</a>
</div>

<?php
}

/**
 * Add stock count to loop.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_template_loop_stock() {
?>

<div class="product__stock">
	<?php echo wc_get_stock_html( wc_get_product( get_post() ) ); // WPCS: XSS okay. ?>
</div>

<?php
};

/**
 * Remove tertiary sidebar on inner pages.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_template_tertiary() {
	// Remove (filters) sidebar on single products.
	if ( is_singular( 'product' ) ) {
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
		// Add (tertiary) sidebar on archives.
	} else {
		add_action(
			'woocommerce_sidebar', function() {
				wc_get_template( 'global/sidebar-tertiary.php' );
			}
		);
	}
}

/**
 * Custom purchase form area.
 *
 * @since 1.0.0
 */
function bigbox_add_to_cart() {
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
			return __( 'Product description', 'bigbox' );
		}
	);

	add_filter(
		'woocommerce_product_additional_information_heading', function() {
			return __( 'Product information', 'bigbox' );
		}
	);

	$tabs['upsells'] = [
		'title'    => __( 'You may also enjoy', 'bigbox' ),
		'priority' => 20,
		'callback' => 'woocommerce_upsell_display',
	];

	if ( isset( $tabs['reviews'] ) ) {
		$tabs['reviews']['priority'] = 30;
	}

	$tabs['related'] = [
		'title'    => __( 'Related products', 'bigbox' ),
		'priority' => 40,
		'callback' => 'woocommerce_output_related_products',
	];

	return $tabs;
}

/**
 * Use set columns for related products and upsells.
 *
 * @since 1.0.0
 *
 * @param array $args Output arguments.
 */
function bigbox_woocommerce_output_related_products_args( $args ) {
	$columns = wc_get_default_products_per_row();

	$args['posts_per_page'] = ( $columns * 2 );
	$args['columns']        = $columns;

	return $args;
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
		echo $attributes; // WPCS: XSS okay.
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
		<strong><?php esc_html_e( 'SKU:', 'bigbox' ); ?></strong>
		<span class="sku"><?php echo esc_html( ( $product->get_sku() ) ? $product->get_sku() : __( 'N/A', 'bigbox' ) ); ?></span>
	</p>

<?php
	endif;

	// @codingStandardsIgnoreStart
	echo wc_get_product_category_list( $product->get_id(), ', ', '<p class="posted_in"><strong>' . esc_html( _n( 'Category:', 'Categories:', count( $product->get_category_ids() ) ), 'bigbox' ) . '</strong> ', '</p>' );

	echo wc_get_product_tag_list( $product->get_id(), ', ', '<p class="tagged_as"><strong>' . esc_html( _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ) ), 'bigbox' ) . '</strong> ', '</p>' );
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

	/* translators: %1$s Rating value. */
	$title = __( '%1$s average rating', 'bigbox' );

	/* Translators: %1$s Number of ratings. */
	$count_title = __( '%1$s customer ratings', 'bigbox' );

	ob_start();
?>

<span class="star-rating__stars" aria-label="<?php esc_attr( sprintf( $title, $rating ) ); ?>">
	<?php
	// @codingStandardsIgnoreStart
	echo str_repeat( bigbox_get_svg( 'star' ), $full_stars );
	echo str_repeat( bigbox_get_svg( 'star-half' ), $half_stars );
	echo str_repeat( bigbox_get_svg( 'star-empty' ), $empty_stars );
	// @codingStandardsIgnoreEnd
	?>
</span>

<?php if ( 0 !== $count && ! is_singular( 'product' ) ) : ?>

	<span class="star-rating__count" aria-label="<?php esc_attr( sprintf( $count_title, $count ) ); ?>">
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
	$args['prev_text'] = bigbox_get_svg( 'arrow-' . ( is_rtl() ? 'right' : 'left' ) ) . esc_html__( 'Previous Page', 'bigbox' );
	$args['next_text'] = esc_html__( 'Next Page', 'bigbox' ) . bigbox_get_svg( 'arrow-' . ( is_rtl() ? 'left' : 'right' ) );

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
	$args['itemWidth']    = absint( wc_get_theme_support( 'single_image_width', get_option( 'woocommerce_single_image_width', 600 ) ) );

	$args['nextText'] = bigbox_get_svg(
		[
			'title' => __( 'Next', 'bigbox' ),
			'icon'  => 'arrow-' . ( is_rtl() ? 'left' : 'right' ),
		]
	);

	$args['prevText'] = bigbox_get_svg(
		[
			'title' => __( 'Previous', 'bigbox' ),
			'icon'  => 'arrow-' . ( is_rtl() ? 'right' : 'left' ),
		]
	);

	$args['thumbnailPosition'] = 'side';

	return $args;
}

/**
 * Grouped product table column order.
 *
 * @since 1.0.0
 *
 * @param array $columns Table columns.
 * @return array
 */
function bigbox_woocommerce_grouped_product_columns( $columns ) {
	$columns = [
		'label',
		'quantity',
		'price',
	];

	return $columns;

}

/**
 * Output markup for mobile shop filter toggles.
 *
 * @since 1.0.0
 */
function bigbox_woocommerce_archive_mobile_filters() {
	wc_get_template( 'loop/shop-filters-mobile.php' );
}

/**
 * Adjust demo store notice classes depending on customizer setting.
 *
 * @since 1.0.0
 *
 * @param string $notice Notice HTML.
 * @return string
 */
function bigbox_woocommerce_demo_store( $notice ) {
	return str_replace( 'demo_store', 'demo_store woocommerce-store-notice--' . get_theme_mod( 'demo-store-notice-position', 'bottom' ), $notice );
};

/**
 * Adjust discount code price HTML.
 *
 * @since 1.11.0
 *
 * @param string $discount_amount_html
 * @return string
 */
function bigbox_woocommerce_coupon_discount_amount_html( $discount_amount_html ) {
	if ( '-' === substr( $discount_amount_html, 0, 1 ) ) {
		$discount_amount_html = ltrim( $discount_amount_html, '-' );
		$discount_amount_html = '<span class="woocommerce-totals-plus">- </span> ' . $discount_amount_html;
	}

	return $discount_amount_html;
}

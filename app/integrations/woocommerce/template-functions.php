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
 * @param string $path Current template path.
 * @return string
 */
function bigbox_woocommerce_template_path( $path ) {
	return 'app/integrations/woocommerce/views/';
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
 * Adjust closing wrapper for categories.
 *
 * Close the opening <ul class="products"> and start a new one.
 *
 * @since 1.0.0
 *
 * @return string
 */
function woocommerce_after_output_product_categories( $output ) {
	ob_start();

	wc_get_template( 'loop/loop-end.php' );
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
	add_filter( 'woocommerce_product_description_heading', function() {
		return esc_html__( 'Product description', 'bigbox' );
	} );

	add_filter( 'woocommerce_product_additional_information_heading', function() {
		return esc_html__( 'Product information', 'bigbox' );
	} );

	return $tabs;
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

	ob_start();
?>

<span class="star-rating__stars" aria-title="<?php printf( esc_html__( '%1$s average rating', 'bigbox' ), $rating ); ?>">
	<?php
	// @codingStandardsIgnoreStart
	echo str_repeat( bigbox_get_svg( 'star' ), $full_stars );
	echo str_repeat( bigbox_get_svg( 'star-half' ), $half_stars );
	echo str_repeat( bigbox_get_svg( 'star-empty' ), $empty_stars );
	// @codingStandardsIgnoreEnd
	?>
</span>

<?php if ( 0 !== $count ) : ?>

	<span class="star-rating__count" aria-title="<?php printf( esc_attr__( '%1$s customer ratings', 'bigbox' ), $count ); ?>"><?php echo esc_html( $count ); ?></span>

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
	$args['delimiter'] = '&nbsp;&#8250;&nbsp;';

	return $args;
}

/**
 * Append to breadcrumbs.
 *
 * @since 1.0.0
 *
 * @param array $crumbs Existing crumbs.
 * @return array
 */
function bigbox_woocommerce_get_breadcrumb( $crumbs ) {
	if ( is_singular( 'product' ) || wc_get_loop_prop( 'total' ) === 0 ) {
		return $crumbs;
	}

	ob_start();
	woocommerce_result_count();
	$count = ob_get_clean();

	$crumbs[] = array(
		$count,
		'',
	);

	return $crumbs;
}

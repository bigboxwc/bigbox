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
	ob_start();
?>

<span class="star-rating__stars">
	<?php
	bigbox_svg( 'star' );
	bigbox_svg( 'star' );
	bigbox_svg( 'star' );
	bigbox_svg( 'star' );
	bigbox_svg( 'star' );
	?>
</span>

<span class="star-rating__count" aria-title="<?php printf( esc_attr__( '%1$s customer ratings', 'bigbox' ), $count ); ?>"><?php echo esc_html( $count ); ?></span>

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

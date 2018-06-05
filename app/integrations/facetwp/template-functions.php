<?php
/**
 * FacetWP template functions.
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
 * FacetWP specific scripts.
 *
 * @since 1.0.0
 */
function bigbox_facetwp_wp_enqueue_scripts() {
	$version    = bigbox_get_theme_version();
	$stylesheet = bigbox_get_theme_name();

	$deps = [
		$stylesheet,
	];

	wp_enqueue_script( "{$stylesheet}-facetwp", get_template_directory_uri() . '/public/js/facetwp.min.js', $deps, $version, true );
}

/**
 * Setup our own loop tags.
 *
 * @since 1.0.0
 */
function bigbox_facetwp_loop() {
	$fwp = FWP();

	remove_action( 'loop_start', [ $fwp->display, 'add_template_tag' ] );
	remove_action( 'loop_no_results', [ $fwp->display, 'add_template_tag' ] );
}

/**
 * Load a separate view for the navbar search.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_facetwp_navbar_search() {
	return bigbox_get_view( 'navbar-search', [], bigbox_get_integration( 'facetwp' )->get_local_path() . '/views/partials' );
}

/**
 * Output FacetWP pagination.
 *
 * @since 1.0.0
 */
function bigbox_facetwp_pagination() {
	echo do_shortcode( '[facetwp pager="true"]' );
}

/**
 * Modify the output of the pagination.
 *
 * @since 1.0.0
 *
 * @param string $output Current output.
 * @param array  $params An associative array of result count settings.
 * @return string
 */
function bigbox_facetwp_pagination_output( $output, $params ) {
	$page        = $params['page'];
	$total_pages = $params['total_pages'];

	$prev = '';
	$next = '';

	if ( $page > 1 ) {
		$prev = '<a data-page="' . ( $page - 1 ) . '" class="facetwp-page prev">' . bigbox_get_svg( 'arrow-' . ( is_rtl() ? 'right' : 'left' ) ) . esc_html__( 'Previous Page', 'bigbox' ) . '</a>';
	}

	if ( $page < $total_pages && $total_pages > 1 ) {
		$next = '<a data-page="' . ( $page + 1 ) . '" class="facetwp-page next">' . esc_html__( 'Next Page', 'bigbox' ) . bigbox_get_svg( 'arrow-' . ( is_rtl() ? 'left' : 'right' ) ) . '</a>';
	}

	return $prev . $output . $next;
}

/**
 * Output FacetWP result count.
 *
 * @since 1.0.0
 */
function bigbox_facetwp_result_count() {
	echo do_shortcode( '[facetwp counts="true"]' );
}

/**
 * Modify the output of the result count.
 *
 * @since 1.0.0
 *
 * @param string $output Current output.
 * @param array  $params An associative array of result count settings.
 * @return string
 */
function bigbox_facetwp_result_count_output( $output, $params ) {
	if ( 0 === $params['total'] ) {
		return;
	}

	if ( $params['lower'] === $params['upper'] || 1 === $params['total'] ) {
		/* translators: %d: total results */
		return sprintf( _n( 'Showing the single result', 'Showing all %d results', $params['total'], 'bigbox' ), $params['total'] ); // @codingStandardsIgnoreLine
	}

	return sprintf(
		// Translators: %1$s Lower count. %2$s Upper count. %3$s Total count.
		__( 'Showing %1$s&ndash;%2$s of %3$s results', 'bigbox' ),
		$params['lower'],
		$params['upper'],
		$params['total']
	);
}

/**
 * Output FacetWP catalog ordering.
 *
 * @since 1.0.0
 */
function bigbox_facetwp_catalog_ordering() {
	echo do_shortcode( '[facetwp sort="true"]' );
}

/**
 * Custom sort options.
 *
 * @since 1.0.0
 *
 * @param array $options Current sorting options.
 * @return array
 */
function bigbox_facetwp_sort_options( $options ) {
	// @codingStandardsIgnoreStart
	$options['price'] = [
		'label'      => __( 'Price (Lowest)', 'bigbox' ),
		'query_args' => [
			'orderby'  => 'meta_value_num',
			'meta_key' => '_price',
			'order'    => 'ASC',
		],
	];

	$options['price-desc'] = [
		'label'      => __( 'Price (Highest)', 'bigbox' ),
		'query_args' => [
			'orderby'  => 'meta_value_num',
			'meta_key' => '_price',
			'order'    => 'DESC',
		],
	];
	// @codingStandardsIgnoreEnd

	return $options;
}

/**
 * Match "No Results Found" with WooCommerce.
 *
 * @since 1.0.0
 *
 * @param string $translated_text Text that has been translated.
 * @param string $text            Text to be translated.
 * @param string $domain          Text domain.
 */
function bigbox_facetwp_gettext_no_results( $translated_text, $text, $domain ) {
	if ( 'No results found' === $text && 'fwp' === $domain ) {
		ob_start();
		wc_get_template( 'loop/no-products-found.php' );
		return ob_get_clean();
	}

	return $translated_text;
}

/**
 * Dynamic navbar facets.
 *
 * @since 1.0.0
 *
 * @param string $mod     Current theme mod value.
 * @param string $source  Source type.
 * @param string $default Current theme mod default.
 * @return string
 */
function bigbox_navbar_dropdown_search_source( $mod, $source, $default ) {
	if ( is_page_template( bigbox_woocommerce_dynamic_shop_page_template() ) ) {
		$mod = get_theme_mod( 'navbar-source-' . $source . '-page-' . get_the_ID(), $default );

		// See if it exists; otherwise fall back to default.
		$try = FWP()->helper->get_facet_by_name( $mod );

		if ( ! $try && '0' !== $mod ) {
			return $default;
		}
	}

	return $mod;
}

/**
 * Ensure [products] shortcode on dynamic shop pages is not cached.
 *
 * @since 1.0.0
 *
 * @param array $atts Shortcode attributes.
 * @return array
 */
function bigbox_woocommerce_shortcode_atts_products( $atts ) {
	if ( is_page_template( bigbox_woocommerce_dynamic_shop_page_template() ) ) {
		$atts['cache'] = false;
	}

	return $atts;
}

/**
 * Add a custom query arg so we know the shortcode is used on a shop page.
 *
 * @since 1.0.0
 *
 * @param array $query_args Query arguments.
 * @return array
 */
function bigbox_woocommerce_shortcode_products_query( $query_args ) {
	if ( is_page_template( bigbox_woocommerce_dynamic_shop_page_template() ) ) {
		$query_args['bigbox_dynamic_shop_page'] = true;
	}

	return $query_args;
}

/**
 * Set a dynamic shop [products] shortcode query to main.
 *
 * @since 1.0.0
 *
 * @param bool     $is_main_query If FacetWP should treat this as the main query.
 * @param WP_Query $wp_query WP_Query object.
 */
function bigbox_facetwp_is_main_query( $is_main_query, $wp_query ) {
	// Standard page query is not main.
	if ( is_page_template( bigbox_woocommerce_dynamic_shop_page_template() ) && did_action( 'bigbox_navbar_after' ) ) {
		// Check if our custom flag is set.
		return isset( $wp_query->query['bigbox_dynamic_shop_page'] );
	}

	return $is_main_query;
}

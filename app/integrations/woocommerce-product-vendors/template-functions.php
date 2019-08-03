<?php
/**
 * WooCommerce Product Vendors template functions.
 *
 * @since 1.14.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Point Product Vendor template overrides to our custom directory.
 *
 * @param string $template Current template path.
 * @param string $template_name Current template name.
 * @return string
 */
function bigbox_woocommerce_product_vendors_locate_template( $template, $template_name ) {
	$overrides = [
		'shortcode-registration-form.php',
	];

	if ( in_array( $template_name, $overrides, true ) ) {
		return get_theme_file_path( 'resources/views/integrations/woocommerce-product-vendors/' . $template_name );
	};

	return $template;
}

/**
 * Enqueue styles.
 *
 * @since 1.16.0
 */
function bigbox_woocommerce_product_vendors_enqueue_styles() {
	$version    = bigbox_get_theme_version();
	$parent     = bigbox_get_theme_name();
	$stylesheet = $parent . '-woocommerce-product-vendors';

	wp_enqueue_style(
		$stylesheet,
		get_template_directory_uri() . '/public/css/woocommerce-product-vendors-css.min.css',
		[],
		$version
	);

	wp_style_add_data(
		$stylesheet,
		'rtl',
		'replace'
	);
}

/**
 * Get vendor data when on a taxonomy archive page.
 *
 * @since 1.14.0
 *
 * @return mixed False if no vendor is found.
 */
function bigbox_wcpv_archive_get_current_vendor() {
	$vendor = get_queried_object_id();

	if ( ! $vendor ) {
		return false;
	}

	if ( ! is_tax( WC_PRODUCT_VENDORS_TAXONOMY, $vendor ) ) {
		return false;
	}

	return get_term_meta( $vendor, 'vendor_data', true );
}

/**
 * "Sold by" to include avatar.
 *
 * @since 1.14.0
 */
function bigbox_wcpv_add_sold_by_loop() {
	$post    = get_post();
	$sold_by = get_option( 'wcpv_vendor_settings_display_show_by', 'yes' );

	if ( is_tax( WC_PRODUCT_VENDORS_TAXONOMY ) ) {
		return;
	}

	if ( 'yes' !== $sold_by ) {
		return;
	}

	$vendor = wp_get_post_terms( $post->ID, WC_PRODUCT_VENDORS_TAXONOMY );

	if ( empty( $vendor ) ) {
		return;
	}

	$vendor      = $vendor[0];
	$vendor_data = WC_Product_Vendors_Utils::get_vendor_data_by_id( $vendor->term_id );
	$sold_by     = WC_Product_Vendors_Utils::get_sold_by_link( $post->ID );
	?>

<div class="product__price product__meta wcpv-sold-by-loop">
	<a href="<?php echo esc_url( $sold_by['link'] ); ?>">
		<?php
		if ( isset( $vendor_data['logo'] ) ) :
			echo wp_get_attachment_image( absint( $vendor_data['logo'] ), 'thumbnail' ); // WPCS: XSS okay.
		endif;
		?>
		<span><?php echo esc_html( $sold_by['name'] ); ?></span>
	</a>
</div>

	<?php
}

/**
 * Show avatar in vendor profile title.
 *
 * @since 1.14.0
 *
 * @param string $title Page title.
 */
function bigbox_wcpv_vendor_page_title( $title ) {
	$vendor_data = bigbox_wcpv_archive_get_current_vendor();

	if ( ! $vendor_data ) {
		return $title;
	}

	$vendor = get_queried_object_id();

	// Show avatar.
	$show_logo = get_option( 'wcpv_vendor_settings_vendor_display_logo', 'yes' );

	if ( ! empty( $vendor_data['logo'] ) && 'yes' === $show_logo ) {
		$title = wp_get_attachment_image( absint( $vendor_data['logo'] ), 'thumbnail' ) . $title;
	}

	// Show ratings.
	$show_ratings = get_option( 'wcpv_vendor_settings_vendor_review', 'yes' );

	if ( $show_ratings ) {
		$title = $title . WC_Product_Vendors_Utils::get_vendor_rating_html( $vendor );
	}

	return $title;
}

/**
 * Vendor profile data.
 *
 * Removes avatar as it's shown in the page title.
 *
 * @since 1.14.0
 */
function bigbox_wcpv_display_vendor_logo_profile() {
	$vendor_data = bigbox_wcpv_archive_get_current_vendor();

	if ( ! $vendor_data ) {
		return;
	}

	$show_profile = get_option( 'wcpv_vendor_settings_vendor_display_profile', 'yes' );

	if ( ! empty( $vendor_data['profile'] ) && 'yes' === $show_profile ) {
		echo '<div class="wcpv-vendor-profile entry-summary">';
		echo wpautop( wp_kses_post( do_shortcode( $vendor_data['profile'] ) ) ); // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
	}
}

/**
 * Vendor rating HTML.
 *
 * @since 1.14.0
 *
 * @param string $rating_html Current rating HTML.
 * @param int    $rating Current rating.
 * @return string
 */
function bigbox_wcpv_vendor_get_rating_html( $rating_html, $rating ) {
	$rating_html = bigbox_get_star_html( $rating );

	return $rating_html;
}

<?php
/**
 * Searching in the nav bar.
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

if ( ! bigbox_is_integration_active( 'woocommerce' ) ) :
	return;
endif;

$dropdown_source = FWP()->helper->get_facet_by_name( get_theme_mod( 'navbar-dropdown-source', null ) );
$search_source   = FWP()->helper->get_facet_by_name( get_theme_mod( 'navbar-search-source', null ) );
?>

<form id="primary-search" action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" method="GET" class="navbar-search">

	<?php if ( $dropdown_source ) : ?>

	<div id="navbar-search__category" class="navbar-search__category">
		<label for="<?php echo esc_attr( $dropdown_source['name'] ); ?>" class="screen-reader-text">
			<?php echo esc_html( $dropdown_source['label'] ); ?>
		</label>
		
		<?php echo facetwp_display( 'facet', $dropdown_source['name'] ); ?>
	</div>

	<?php endif; ?>

	<div class="navbar-search__keywords">
		<label for="<?php echo esc_attr( $search_source['name'] ); ?>" class="screen-reader-text">
			<?php echo esc_html( $search_source['label'] ); ?>
		</label>

		<?php echo facetwp_display( 'facet', $search_source['name'] ); ?>
	</div>

	<div class="navbar-search__submit">
		<button type="submit" aria-title="<?php esc_attr_e( 'Search', 'bigbox' ); ?>">
			<?php bigbox_svg( 'search' ); ?>
		</button>

		<input type="hidden" name="post_type" value="product" />
	</div>

	<div class="facetwp-template"></div>

</form>

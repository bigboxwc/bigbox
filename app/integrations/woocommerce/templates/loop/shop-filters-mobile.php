<?php
/**
 * Mobile filter toggles.
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

$sidebar = bigbox_get_dynamic_sidebar( 'shop' );

if ( ! $sidebar ) :
	return;
endif;
?>

<div class="woocommerce-products-header__filter-toggle">
	<a href="#shop-filters-mobile" class="shop-filters-mobile-toggle" aria-expanded="false" aria-controls="shop-filters-mobile" aria-label="<?php esc_attr_e( 'Filter', 'bigbox' ); ?>" role="button">
		<?php
		bigbox_svg( 'menu' );
		esc_html_e( 'Filter', 'bigbox' );
		?>
	</a>

	<div id="shop-filters-mobile" class="offcanvas-drawer">
		<a href="#shop-filters-mobile-toggle" class="offcanvas-drawer__close" aria-label="<?php esc_attr_e( 'Close filters', 'bigbox' ); ?>">
			<?php esc_html_e( 'Close', 'bigbox' ); ?>
		</a>

		<?php echo $sidebar; // @codingStandardsIgnoreLine ?>
	</div>

	<a id="shop-filters-mobile" href="#shop-filters-mobile-toggle" class="offcanvas-drawer-backdrop" tabindex="-1" aria-hidden="true" aria-label="<?php esc_attr_e( 'Close filters', 'bigbox' ); ?>" hidden="true"></a>
</div>

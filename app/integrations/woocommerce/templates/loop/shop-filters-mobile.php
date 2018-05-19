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
?>

<div class="shop-filters__mobile-toggle">
	<a href="#shop-filters-mobile" class="shop-filters__mobile-toggle-link offcanvas-drawer-toggle" aria-expanded="false" aria-controls="shop-filters-mobile" aria-label="<?php esc_attr_e( 'Filter', 'bigbox' ); ?>" role="button" data-source="#secondary" data-target="#shop-filters-mobile">
		<?php
		esc_html_e( 'Filter Results', 'bigbox' );
		bigbox_svg( 'filter' );
		?>
	</a>

	<div id="shop-filters-mobile" class="offcanvas-drawer">
		<a href="#shop-filters-mobile-toggle" class="offcanvas-drawer__close offcanvas-drawer-toggle" aria-label="<?php esc_attr_e( 'Close filters', 'bigbox' ); ?>" data-source="#shop-filters-mobile" data-target="#secondary">
			<?php esc_html_e( 'Close', 'bigbox' ); ?>
		</a>

		<div class="offcanvas-drawer__content"></div>
	</div>

	<a href="#shop-filters-mobile-toggle" class="offcanvas-drawer-backdrop offcanvas-drawer-toggle" tabindex="-1" aria-hidden="true" aria-label="<?php esc_attr_e( 'Close filters', 'bigbox' ); ?>" hidden="true" data-source="#shop-filters-mobile" data-target="#secondary"></a>
</div>

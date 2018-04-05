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
	<a href="#navbar-filter" class="" aria-expanded="false" aria-controls="navbar-mobile" aria-label="<?php esc_attr_e( 'Filter', 'bigbox' ); ?>" role="button">
		<?php esc_html_e( 'Filter', 'bigbox' ); ?>
	</a>

	<div id="navbar-filter" class="navbar-mobile">
		<a href="#navbar-mobile-toggle" class="navbar-mobile__close" aria-label="<?php esc_attr_e( 'Close menu', 'bigbox' ); ?>"><?php esc_html_e( 'Close', 'bigbox' ); ?></a>

		<?php echo $sidebar; // @codingStandardsIgnoreLine ?>
	</div>

	<a id="navbar-mobile-toggle" href="#navbar-mobile-toggle" class="navbar-mobile-backdrop" tabindex="-1" aria-hidden="true" aria-label="<?php esc_attr_e( 'Close filters', 'bigbox' ); ?>" hidden=""></a>
</div>

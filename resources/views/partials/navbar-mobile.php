<?php
/**
 * Mobile navbar.
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

$menus = bigbox_get_primary_nav_menus();

if ( '' === $menus ) :
	return;
endif;
?>

<a href="#navbar-mobile" class="offcanvas-drawer-toggle navbar-mobile-toggle--open" aria-expanded="false" aria-controls="navbar-mobile" aria-label="<?php esc_attr_e( 'Open menu', 'bigbox' ); ?>" role="button" data-source="#navbar-primary" data-target="#navbar-mobile">
	<?php bigbox_svg( 'menu' ); ?>
</a>

<nav id="navbar-mobile" class="offcanvas-drawer navbar--mobile">
	<a href="#navbar-mobile-toggle" class="offcanvas-drawer__close offcanvas-drawer-toggle" aria-label="<?php esc_attr_e( 'Close menu', 'bigbox' ); ?>" data-source="#navbar-mobile" data-target="#navbar-primary">
		<?php esc_html_e( 'Close', 'bigbox' ); ?>
	</a>

	<div class="offcanvas-drawer__content"></div>
</nav>

<a id="navbar-mobile-toggle" href="#navbar-mobile-toggle" class="offcanvas-drawer-backdrop offcanvas-drawer-toggle" tabindex="-1" aria-hidden="true" aria-label="<?php esc_attr_e( 'Close menu', 'bigbox' ); ?>" hidden="true" data-source="#navbar-mobile" data-target="#navbar-primary"></a>

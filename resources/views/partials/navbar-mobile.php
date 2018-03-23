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
?>

<a href="#navbar-mobile" class="navbar-mobile-toggle navbar-mobile-toggle--open" aria-expanded="false" aria-controls="navbar-mobile" aria-label="<?php esc_attr_e( 'Open menu', 'bigbox' ); ?>" role="button">
	<?php bigbox_svg( 'menu' ); ?>
</a>

<nav id="navbar-mobile" class="navbar-mobile">
	<a href="#navbar-mobile-toggle" class="navbar-mobile__close" aria-label="<?php esc_attr_e( 'Close menu', 'bigbox' ); ?>"><?php esc_html_e( 'Close', 'bigbox' ); ?></a>

	<?php echo bigbox_get_primary_nav_menus(); // @codingStandardsIgnoreLine ?>
</nav>

<a id="navbar-mobile-toggle" href="#navbar-mobile-toggle" class="navbar-mobile-backdrop" tabindex="-1" aria-hidden="true" aria-label="<?php esc_attr_e( 'Close menu', 'bigbox' ); ?>" hidden=""></a>

<?php
/**
 * Navbar menu.
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

if ( '' === trim( $menus ) ) :
	return;
endif;
?>

<div id="navbar-primary" class="navbar-menu navbar-menu--primary">
	<div class="offcanvas-drawer__content" role="navigation">
		<?php echo $menus; // @codingStandardsIgnoreLine ?>
	</div>
</div>

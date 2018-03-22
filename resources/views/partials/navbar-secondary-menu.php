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

<div class="navbar-menu navbar-menu--secondary">

	<?php echo $menus; // @codingStandardsIgnoreLine ?>

</div>

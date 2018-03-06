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
?>

<div class="navbar-menu navbar-menu--secondary">
	<ul class="navbar-menu__items">

		<li class="navbar-menu__item">
			<a href="#">All Departments</a>

			<ul class="megamenu">
				<li class="megamenu__parent-item">
					<a href="#">Electronics</a>
				</li>
			</ul>

		</li>

		<li class="navbar-menu__item">
			<a href="#">
				<?php bigbox_svg( 'heart' ); ?>
				Saved Items
			</a>
		</li>

	</ul>
</div>

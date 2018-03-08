<?php
/**
 * Navbar primary menu.
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


<div class="navbar-menu navbar-menu--primary">
	<ul class="navbar-menu__items">

		<li class="navbar-menu__item navbar-menu__item--stacked">
			<a href="#">
				<?php bigbox_svg( 'user' ); ?>
				Account
			</a>
		</li>

		<li class="navbar-menu__item navbar-menu__item--stacked">
			<a href="#">
				<?php bigbox_svg( 'basket' ); ?>
				Cart
			</a>
		</li>

	</ul>
</div>

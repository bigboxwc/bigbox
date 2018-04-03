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

$count = count( WC()->cart->get_cart_contents() );

if ( ! bigbox_is_integration_active( 'woocommerce' ) ) :
	return;
endif;
?>

<div class="navbar-menu navbar-menu--primary">
	<ul class="navbar-menu__items">

		<li class="navbar-menu__item navbar-menu__item--stacked">
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">
				<?php
				bigbox_svg( 'user' );
				esc_html_e( 'Account', 'bigbox' );
				?>
			</a>
		</li>

		<li class="navbar-menu__item navbar-menu__item--stacked">
			<a href="<?php echo esc_url( 0 === $count ? get_permalink( wc_get_page_id( 'shop' ) ) : wc_get_cart_url() ); ?>">
				<span class="navbar-menu__cart-count"><?php echo esc_html( $count ); ?></span>
				<?php
				bigbox_svg( 'cart' );
				esc_html_e( 'Cart', 'bigbox' );
				?>
			</a>
		</li>

	</ul>
</div>

<?php
/**
 * Template Name: Homepage
 *
 * Customized shop homepage.
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

bigbox_view( 'global/header' );
?>

<div id="main" class="site-primary" role="main">
	<?php
	/**
	 * @hooked bigbox_shop_home_onsale - 10
	 */
	do_action( 'bigbox_shop_home' );

	/**
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action( 'woocommerce_sidebar' );
	?>
</div>

<?php
bigbox_view( 'global/footer' );

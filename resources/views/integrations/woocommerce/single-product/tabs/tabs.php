<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$wc_tabs = apply_filters( 'woocommerce_product_tabs', [] );

if ( ! empty( $wc_tabs ) ) : ?>

	<div class="woocommerce-single-product-data">

	<?php
	foreach ( $wc_tabs as $key => $wc_tab ) :
		if ( isset( $wc_tab['callback'] ) ) :
			ob_start();

			call_user_func( $wc_tab['callback'] );

			$content = trim( ob_get_clean() );

			if ( '' !== $content ) :
				?>

		<div class="woocommerce-single-product-data__section woocommerce-single-product-data__section-<?php echo esc_attr( $key ); ?>" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php echo $content; // WPCS: XSS okay. ?>
		</div>

				<?php
			endif;
		endif;
	endforeach;
			
	do_action( 'woocommerce_product_after_tabs' );
	?>

	</div>

<?php endif; ?>

<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
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
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$facetwp = bigbox_is_integration_active( 'facetwp' );

if ( $facetwp ) : ?>

	<?php wc_get_template( 'loop/loop-start.php' ); ?>
	<!--fwp-loop-->
	<li class="woocommerce-notice woocommerce-notice--notice card facetwp-template__no-results" role="alert">
		<?php esc_html_e( 'No products were found matching your selection.', 'bigbox' ); ?>
	</li>
	<?php wc_get_template( 'loop/loop-end.php' ); ?>

	<?php
else :

	esc_html_e( 'No products were found matching your selection.', 'bigbox' );

endif;

<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$classes = [
	'products',
	'products-' . wc_get_loop_prop( 'products-loop', 'main' ),
	'columns-' . wc_get_loop_prop( 'columns' ),
	( 'main' === wc_get_loop_prop( 'products-loop' ) ? 'facetwp-template' : null ),
	( wc_get_loop_prop( 'total' ) <= wc_get_loop_prop( 'columns' ) ? 'products--single-row' : null ),
];
?>

<ul class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

<?php if ( bigbox_is_integration_active( 'facetwp' ) ) : ?>
<!--fwp-loop-->
<?php endif; ?>

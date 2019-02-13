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

$single_row = (
	( wc_get_loop_prop( 'per_page' ) <= wc_get_loop_prop( 'columns' ) ) &&
	( 0 !== wc_get_loop_prop( 'per_page' ) )
);

$main = 'main' === wc_get_loop_prop( 'products-loop' );

$classes = classNames(
	'products',
	'products-' . wc_get_loop_prop( 'products-loop', 'main' ),
	'columns-' . wc_get_loop_prop( 'columns' ),
	[
		'facetwp-template'     => $main,
		'products--single-row' => $single_row,
	]
);
?>

<ul class="<?php echo esc_attr( $classes ); ?>">

<?php if ( bigbox_is_integration_active( 'facetwp' ) && $main ) : ?>
<!--fwp-loop-->
<?php endif; ?>

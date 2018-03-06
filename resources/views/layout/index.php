<?php
/**
 * Blog index.
 *
 * @since 1.0.0
 * @version 1.0.0
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

<div class="container">
	<div class="product-grid">
		<?php bigbox_partial( 'product-card' ); ?>
		<?php bigbox_partial( 'product-card' ); ?>
		<?php bigbox_partial( 'product-card' ); ?>
		<?php bigbox_partial( 'product-card' ); ?>
	</div>
</div>

<?php
bigbox_view( 'global/footer' );

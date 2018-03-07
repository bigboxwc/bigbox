<?php
/**
 * Tertiary sidebar.
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

if ( ! is_active_sidebar( 'shop-tertiary' ) ) :
	return;
endif;
?>

<div id="tertiary" class="site-tertiary" role="complementary">
	<?php dynamic_sidebar( 'shop-tertiary' ); ?>
</div>

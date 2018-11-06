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

$sidebar = bigbox_get_cached_sidebar( 'shop-tertiary' );

if ( ! $sidebar || is_singular( 'product' ) ) :
	return;
endif;
?>

<div id="tertiary" class="site-tertiary" role="complementary">
		<?php echo $sidebar; // WPCS: XSS okay. ?>
</div>

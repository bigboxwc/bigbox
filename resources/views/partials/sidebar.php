<?php
/**
 * Dynamic sidebar.
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

$sidebar = bigbox_get_cached_sidebar( $sidebar_id );

if ( ! $sidebar ) :
	return;
endif;
?>

<div id="secondary" class="site-secondary shop-filters" role="complementary">
	<div class="offcanvas-drawer__content">
		<?php echo $sidebar; // WPCS: XSS okay. ?>
	</div>
</div>

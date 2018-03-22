<?php
/**
 * Footer navigation.
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

$count = bigbox_get_footer_nav_columns();
?>

<div class="footer-nav">
	<div class="container">
		<div class="row">

			<?php for ( $i = 1; $i <= $count; $i++ ) : ?>
			<div class="col">
				<?php dynamic_sidebar( 'footer-' . $i ); ?>
			</div>
			<?php endfor; ?>

		</div>
	</div>
</div>

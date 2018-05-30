<?php
/**
 * Customize(r) controls.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */
?>

<div class="popover wp-pointer wp-pointer-left">
  <div class="wp-pointer-content">
		<h3 class="popover-header"></h3>
		<p class="popover-body"></p>
		<div class="wp-pointer-buttons">
			<a class="close" href="#"><?php esc_html_e( 'Exit', 'bigbox' ); ?></a>
			<a class="next" href="#"><?php esc_html_e( 'Next', 'bigbox' ); ?> &rarr;</a>
		</div>
  </div>

  <div class="wp-pointer-arrow">
	<div class="wp-pointer-arrow-inner"></div>
  </div>
</div>

<?php
/**
 * Footer copyright.
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
?>

<div class="footer-copyright">
	<div class="container">
		<p><?php echo esc_html( get_theme_mod( 'copyright', sprintf( '&copy; %s. All Rights Reserved.', get_bloginfo( 'name' ) ) ) ); ?></p>
	</div>
</div>

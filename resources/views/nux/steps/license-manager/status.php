<?php
/**
 * License Manager status information.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<strong><?php esc_html_e( 'License Status:', 'bigbox' ); ?></strong>

<# if ( data.isPending ) { #>
	<span class="spinner is-active"></span>
<# } else { #>
	<span class="{{ data.className }}">{{ data.status }}</span>
<# } #>

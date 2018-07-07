<?php
/**
 * License Manager deactivate.
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

<# if ( data.isValid ) { #>
<button
	class="button"
	<# if ( data.isPending ) { #>disabled<# } #>
>
	<?php esc_html_e( 'Deactivate', 'bigbox' ); ?>
</button>
<# } #>

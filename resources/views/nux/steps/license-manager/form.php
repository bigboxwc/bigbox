<?php
/**
 * License Manager form.
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

<form class="bigbox-activate-license">
	<input
		type="text"
		name="license"
		value="{{ data.license }}"
		class="{{ data.className }}"
	/>

	<input
		type="submit"
		name="submit"
		class="button button-large button-primary"
		value="<?php echo esc_html_e( 'Activate License', 'bigbox' ); ?>"
		<# if ( data.isPending || data.isValid ) { #>disabled<# } #>
	/>
</form>

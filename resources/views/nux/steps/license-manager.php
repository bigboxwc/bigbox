<?php
/**
 * Activate purchase.
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

wp_enqueue_script( 'bigbox-license-manager' );
?>

<p>
<?php
// Translators: %1$s Opening HTML <a> tag. Do not translate. %2$s Closing HTML tag. Do not transslate.
echo wp_kses_post( sprintf( __( 'Please enter the license key received with your purchase to enable automatic updates and ensure your website stays up to date and secure. You can find your license key on your %1$sBigBox account page%2$s.', 'bigbox' ), '<a href="https://bigboxwc.com/account">', '</a>' ) );
?>
</p>

<div id="bigbox-license-manager">

</div>

<script type="text/html" id="tmpl-bigbox-license-manager-form">
	<form class="bigbox-activate-license">
		<input type="text" name="license" value="{{ data.key }}" class="{{ data.className }}">
		<input type="submit" name="submit" class="button button-large button-primary">
	</form>
</script>

<script type="text/html" id="tmpl-bigbox-license-manager-status">
	<strong><?php esc_html_e( 'License Status:', 'bigbox' ); ?></strong>
	<# if ( data.isPending ) { #>
		<span class="spinner is-active"></span>
	<# } else { #>
		<span class="{{ data.className }">{{ data.status }}</span>
	<# } #>
</script>

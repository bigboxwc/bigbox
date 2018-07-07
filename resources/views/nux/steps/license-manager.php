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

<div id="bigbox-license-manager"></div>

<?php foreach ( [ 'form', 'status', 'deactivate' ] as $view ) : ?>
<script type="text/html" id="tmpl-bigbox-license-manager-<?php echo esc_attr( $view ); ?>">
	<?php bigbox_view( 'nux/steps/license-manager/' . $view ); ?>
</script>
<?php endforeach; ?>

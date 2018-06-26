<?php
/**
 * Admin notice license reminder.
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

// Just in case this somehow is not loaded.
wp_enqueue_script( 'wp-utils' );
?>

<div id="bigbox-license-reminder-notice" class="notice notice-error is-dismissible">
	<p>
	<?php
		echo wp_kses_post( __( '<strong>You have not entered your BigBox license key!</strong> You will not be able to automatically update your BigBox theme.', 'bigbox' ) . ' <a href="' . esc_url( add_query_arg( 'page', 'bigbox', admin_url( 'themes.php' ) ) ) . '">' . __( 'Add your license key now &rarr;', 'bigbox' ) . '</a>' );
	?>
	</p>
</div>

<script>
jQuery( function( $ ) {
	$( '#bigbox-license-reminder-notice' ).on( 'click', '.notice-dismiss', function(e) {
		e.preventDefault();

		wp.ajax.send( 'bigbox_notice_dismiss_license_reminder', {
			data: {
				security: <?php echo wp_json_encode( wp_create_nonce( 'bigbox_notice_dismiss_license_reminder' ) ); ?>
			}
		} );
	});
});
</script>

<?php
/**
 * Customize
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

<p><?php esc_html_e( 'Need a quick and easy setup to demo your store? Let us help you design your store by walking you through the customization process.', 'bigbox' ); ?></p>

<form action="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>" method="GET">
	<p>
		<label for="starter-content">
				<input type="checkbox" name="starter-content" id="starter-content" value="1" />
				<?php esc_html_e( 'Import starter content', 'bigbox' ); ?>
		</label>
	</p>

	<button type="submit" class="button button-primary button-large"><?php esc_html_e( 'Customize Your Store', 'bigbox' ); ?></button>

	<input type="hidden" name="page" value="bigbox" />
	<input type="hidden" name="walkthrough" value="1" />
	<input type="hidden" name="starter-content-redirect" value="1" />
</form>

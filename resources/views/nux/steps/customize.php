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

<p><?php esc_html_e( 'Manage the appearance and behavior of various theme components with the live customizer.', 'bigbox' ); ?></p>

<ul>
	<li><a href="<?php echo esc_url_raw( admin_url( 'customize.php?autofocus[section]=title_tagline' ) ); ?>">
		<?php esc_html_e( 'Add a custom logo', 'bigbox' ); ?>
	</a></li>

	<li><a href="<?php echo esc_url_raw( admin_url( 'customize.php?autofocus[section]=static_front_page' ) ); ?>">
		<?php esc_html_e( 'Update homepage display', 'bigbox' ); ?>
	</a></li>

	<li><a href="<?php echo esc_url_raw( admin_url( 'customize.php?autofocus[panel]=colors' ) ); ?>">
		<?php esc_html_e( 'Choose custom colors', 'bigbox' ); ?>
	</a></li>

	<li><a href="<?php echo esc_url_raw( admin_url( 'customize.php?autofocus[section]=type' ) ); ?>">
		<?php esc_html_e( 'Choose a new typeface', 'bigbox' ); ?>
	</a></li>
</ul>

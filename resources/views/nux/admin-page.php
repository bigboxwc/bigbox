<?php
/**
 * Admin page for Setup Guide.
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

wp_enqueue_style( 'bigbox-nux' );
wp_enqueue_script( 'bigbox-nux' );
?>

<div class="wrap about-wrap bigbox-setup-guide">
	<h1><?php esc_html_e( '🎉 Welcome to BigBox', 'bigbox' ); ?></h1>

	<p class="about-text">
		<?php echo wp_kses_post( __( 'Use the steps below to finish setting up your new website.', 'bigbox' ) ); ?>
	</p>

	<p class="helpful-links">
		<a href="" class="button button-primary js-trigger-documentation" target="_blank"><?php esc_html_e( 'Search Documentation', 'bigbox' ); ?></a>&nbsp;
		<a href="" class="button button-secondary" target="_blank"><?php esc_html_e( 'Contact Support', 'bigbox' ); ?></a>&nbsp;
	</p>
</div>

<div id="poststuff" class="wrap bigbox-setup-guide-steps">
	<?php do_accordion_sections( 'bigbox-setup-steps', 'normal', null ); ?>
</div>

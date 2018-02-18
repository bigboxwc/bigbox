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
?>

<p><?php esc_html_e( 'Please enter the license key received with your purchase to enable automatic updates and ensure your website stays up to date and secure.', 'bigbox' ); ?></p>

<div id="bigbox-activate-license"></div>

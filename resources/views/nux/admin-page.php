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
?>

<div class="wrap about-wrap bigbox-setup-guide">
	<h1><?php esc_html_e( '📦 Welcome to BigBox', 'bigbox' ); ?></h1>

	<p class="about-text">
		<?php echo wp_kses_post( __( 'Use the steps below to finish setting up your new website.', 'bigbox' ) ); ?>
	</p>

	<p class="helpful-links">
		<a href="https://docs.bigbowc.com/" class="button button-primary" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Search Documentation', 'bigbox' ); ?></a>&nbsp;
		<a href="https://bigboxwc.com/account/support" class="button button-secondary" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Contact Support', 'bigbox' ); ?></a>
	</p>
</div>

<div id="poststuff" class="wrap bigbox-setup-guide-steps">
	<?php do_accordion_sections( 'bigbox-setup-steps', 'normal', null ); ?>
</div>

<script>!function(e,o,n){window.HSCW=o,window.HS=n,n.beacon=n.beacon||{};var t=n.beacon;t.userConfig={},t.readyQueue=[],t.config=function(e){this.userConfig=e},t.ready=function(e){this.readyQueue.push(e)},o.config={docs:{enabled:!0,baseUrl:"https://bigbox.helpscoutdocs.com/"},contact:{enabled:!1,formId:"e015d0b0-45ce-11e8-8d65-0ee9bb0328ce"}};var r=e.getElementsByTagName("script")[0],c=e.createElement("script");c.type="text/javascript",c.async=!0,c.src="https://djtflbt20bdde.cloudfront.net/",r.parentNode.insertBefore(c,r)}(document,window.HSCW||{},window.HS||{});</script>

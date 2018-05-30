<?php
/**
 * Customize(r) controls.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */
?>

<div aria-hidden class="bigbox-pointer"></div>

<script type="text/html" id="tmpl-bigbox-pointer">
	<h3>{{ data.title }}</h3>
	<p class="popover-body">{{ data.content }}</p>

	<div class="bigbox-pointer__buttons">
		<a class="close" href="#"><?php esc_html_e( 'Exit', 'bigbox' ); ?></a>

		<# if ( ! data.last ) { #>
			<a class="next" href="#"><?php esc_html_e( 'Next', 'bigbox' ); ?> &rarr;</a>
		<# } #>
	</div>
</script>

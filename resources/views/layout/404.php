<?php
/**
 * 404
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

bigbox_view( 'global/header' );
?>

<div id="main" class="site-primary site-primary--8">
	<h1 class="page-title page-title--xl"><?php esc_html_e( 'Page Not Found', 'bigbox' ); ?></h1>
	<p><?php esc_html_e( 'Try searching again!', 'bigbox' ); ?></p>
	<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button"><?php esc_html_e( 'Go Home', 'bigbox' ); ?></a></p>
</div>

<?php
bigbox_view( 'global/footer' );

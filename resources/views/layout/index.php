<?php
/**
 * Blog index.
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

<div id="main" class="site-primary" role="main">
	<h1 class="page-title"><?php echo get_option( 'page_for_posts' ) ? esc_html( get_the_title( get_option( 'page_for_posts' ) ) ) : esc_html__( 'Blog', 'bigbox' ); ?></h1>
</div>

<?php
bigbox_view( 'global/footer' );

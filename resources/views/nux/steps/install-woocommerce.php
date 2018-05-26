<?php
/**
 * Install recommended plugins.
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

$plugin = new BigBox\NUX\WooCommerce_ListTable();
$plugin->prepare_items();
$plugin->display();

add_thickbox();
?>

<p>
	<a href="<?php echo esc_url( add_query_arg( 'page', 'wc-setup', admin_url( 'admin.php' ) ) ); ?>&TB_iframe=true&width=600&height=550" class="button button-primary button-large thickbox"><?php esc_html_e( 'Setup WooCommerce', 'bigbox' ); ?></a>
</p>

<?php
/**
 * Do not modify this file.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Bootstrap
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Do not allow the theme to be active if the PHP version is not met.
 *
 * Revert to the default theme and display a notice in the admin.
 *
 * @since 1.0.0
 */
define( 'BIGBOX_PHP_VERSION', '7.0.0' );

if ( version_compare( PHP_VERSION, BIGBOX_PHP_VERSION, '<=' ) ) {
	add_action(
		'admin_notices', function() {
			// Translators: %s Minimum PHP version required for theme to run.
			echo '<div class="notice notice-error"><p>' . sprintf( esc_html__( 'BigBox requires PHP version <code>%s</code> or above to be active. Please contact your web host to upgrade.', 'bigbox' ), esc_attr( BIGBOX_PHP_VERSION ) ) . '</p></div>';
		}
	);

	switch_theme( WP_DEFAULT_THEME );

	return;
}

// Composer autoloader.
require_once __DIR__ . '/bootstrap/autoload.php';

// Custom template loader.
require_once __DIR__ . '/bootstrap/template-loader.php';

// Start things.
require_once __DIR__ . '/bootstrap/app.php';
add_action( 'woocommerce_cart_calculate_fees','woocommerce_custom_surcharge' );
function woocommerce_custom_surcharge() {
  global $woocommerce;

	if ( is_admin() && ! defined( 'DOING_AJAX' ) )
		return;

	$percentage = 0.01;
	$surcharge = ( $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total ) * $percentage;	
	$woocommerce->cart->add_fee( 'Surcharge', $surcharge, true, '' );

}

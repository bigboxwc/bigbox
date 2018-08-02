<?php
/**
 * Show notice messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<?php if ( $messages ) : ?>
	<div class="woocommerce-notice woocommerce-notice--notice card" role="alert">
	<ul class="woocommerce-notice-list">
	  <?php foreach ( $messages as $message ) : ?>
		<li class="woocommerce-notice-list__item"><?php echo wp_kses_post( $message ); ?></li>
		<?php endforeach; ?>
	</ul>
	</div>
<?php endif; ?>

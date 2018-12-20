<?php
/**
 * Dynamic shop page.
 *
 * Emulate the `archive-product.php` archive template but load page content instead.
 *
 * This page template needs to be kept in sync with `archive-product.php`.
 *
 * @since 1.0.0
 * @version 3.4.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

while ( have_posts() ) :
	the_post();
	?>

<header class="woocommerce-products-header">
	<h1 class="woocommerce-products-header__title page-title"><?php the_title(); ?></h1>
</header>

	<?php
	the_content();
endwhile;

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );

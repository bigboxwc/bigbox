<?php
/**
 * Searching in the nav bar.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<form id="primary-search" action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" method="GET" class="navbar-search">

<?php
/**
 * Filters the HTML for the search in the navbar.
 *
 * @since 1.0.0
 */
echo apply_filters( 'bigbox_navbar_search', '' );
?>

</form>

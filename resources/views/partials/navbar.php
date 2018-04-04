<?php
/**
 * Global navbar.
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

<div class="navbar">

	<div class="navbar__inner">
		<?php
		bigbox_partial( 'navbar-mobile' );
		bigbox_partial( 'branding' );
		
		/**
		 * Filters the HTML for the search in the navbar.
		 *
		 * @since 1.0.0
		 */
		echo apply_filters( 'bigbox_navbar_search', bigbox_get_view( 'navbar-search', [], 'resources/views/partials' ) );

		bigbox_partial( 'navbar-primary-menu' );
		?>
	</div>

	<?php bigbox_partial( 'navbar-secondary-menu' ); ?>

</div>

<?php do_action( 'bigbox_navbar_after' ); ?>

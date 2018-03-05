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
	
	<?php
	bigbox_partial( 'branding' );
	bigbox_partial( 'navbar-search' );
	bigbox_partial( 'navbar-primary-menu' );
	bigbox_partial( 'navbar-secondary-menu' );
	?>
	
</div>

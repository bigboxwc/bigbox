<?php
/**
 * Global branding.
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

$tag = is_home() || is_front_page() ? 'h1' : 'p';
?>

<<?php echo esc_attr( $tag ); ?> class="branding">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php bloginfo( 'name' ); ?>
	</a>
</<?php echo esc_attr( $tag ); ?>>

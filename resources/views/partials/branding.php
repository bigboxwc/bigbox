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

$html_tag = is_front_page() ? 'h1' : 'p';
$text     = (bool) get_theme_mod( 'header_text', 1 );
?>

<div class="branding">
	<?php the_custom_logo(); ?>

	<<?php echo esc_attr( $html_tag ); ?> class="site-title<?php echo esc_attr( $text ? null : ' screen-reader-text' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
	</<?php echo esc_attr( $html_tag ); ?>>

	<p class="screen-reader-text"><?php bloginfo( 'description' ); ?></p>
</div>

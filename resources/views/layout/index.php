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

<div id="main" class="site-primary site-primary--8">
	<h1 class="page-title page-title--lg">
		<?php if ( is_archive() ) : ?>
			<?php the_archive_title(); ?>
		<?php else : ?>
			<?php echo get_option( 'page_for_posts' ) ? esc_html( get_the_title( get_option( 'page_for_posts' ) ) ) : esc_html__( 'Blog', 'bigbox' ); ?>
		<?php endif; ?>
	</h1>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();

			bigbox_partial( 'content' );
		endwhile;

		bigbox_partial( 'content-pagination' );
	else :
			bigbox_partial( 'content-none' );
	endif;
	?>
	</div>

</div>

<?php
bigbox_view( 'global/footer' );

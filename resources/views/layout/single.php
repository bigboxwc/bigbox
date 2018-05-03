<?php
/**
 * Single blog post.
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

while ( have_posts() ) :
	the_post();
?>


<div id="main" class="site-primary site-primary--8">
	<h1 class="page-title page-title--lg"><?php the_title(); ?></h1>

	<div class="hentry blog-post__content">
		<?php
		the_content();
		wp_link_pages();
		?>
	</div>

	<?php
	printf( '<p class="blog-post__meta">' . esc_html__( 'Categories: %s', 'bigbox' ) . '</p>', get_the_category_list( ', ' ) ); // WPCS: XSS okay.
	the_tags( '<p class="blog-post__meta">' . esc_html__( 'Tags:', 'bigbox' ) . ' ', ', ', '</p>' );
	comments_template( '/resources/views/partials/content-comments.php' );
	?>
</div>

<?php
endwhile;

bigbox_view( 'global/footer' );

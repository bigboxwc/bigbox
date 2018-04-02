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
		<?php the_content(); ?>
	</div>
</div>

<?php
endwhile;

bigbox_view( 'global/footer' );

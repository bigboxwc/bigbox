<?php
/**
 * Blog archive content.
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
?>

<div class="blog-post">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="alignwide">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'large' ); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="block-header blog-post__header">
		<h3 class="block-title blog-post__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
	</div>

	<div class="hentry blog-post__content">
		<?php the_excerpt(); ?>
	</div>

</div>

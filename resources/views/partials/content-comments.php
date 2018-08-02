<?php
/**
 * Single blog comments.
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

if ( comments_open() && get_option( 'thread_comments' ) ) :
	wp_enqueue_script( 'comment-reply' );
endif;

if ( ! comments_open() && ! have_comments() ) :
	return;
endif;

if ( have_comments() ) :
	?>

<div class="comments">
	<h3 class="commentlist-title ">
		<?php comments_number( esc_html__( '0 Comments', 'bigbox' ), esc_html__( '1 Comment', 'bigbox' ), esc_html__( '% Comments', 'bigbox' ) ); ?>
	</h3>

	<?php
	endif;

if ( have_comments() ) :
	?>

	<ol class="commentlist">
	<?php wp_list_comments(); ?>
	</ol>

	<?php the_comments_pagination(); ?>

</div>

	<?php
endif;

if ( comments_open() ) :
	/**
	 * Filters the arguments used to build the blog comment form.
	 *
	 * @since 1.12.1
	 *
	 * @param array $args comment_fomr() arguments.
	 */
	$comment_form = apply_filters( 'bigbox_blog_comment_form_args', [] );

	comment_form( $comment_form );
endif;

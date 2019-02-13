<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! bigbox_wc_review_ratings_enabled() ) {
	return;
}

$product = wc_get_product( get_the_ID() );

if ( ! comments_open() ) :
	return;
endif;
?>

<div id="reviews" class="woocommerce-Reviews">

	<div class="woocommerce-reviews__main">
		<div id="comments">
			<h2 class="woocommerce-Reviews-title">
			<?php
			/* translators: %d Review count. */
			echo esc_html( sprintf( _n( '%d customer review', '%d customer reviews', $product->get_review_count(), 'bigbox' ), $product->get_review_count() ) );
			?>
			</h2>

			<?php if ( have_comments() ) : ?>

				<ol class="commentlist">
					<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', [ 'callback' => 'woocommerce_comments' ] ) ); ?>
				</ol>

				<?php
				if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
					echo '<nav class="woocommerce-pagination">'; // WPCS: XSS okay.
					paginate_comments_links(
						apply_filters(
							'woocommerce_comment_pagination_args',
							[
								'prev_text' => '&larr;',
								'next_text' => '&rarr;',
								'type'      => 'list',
							]
						)
					);
					echo '</nav>'; // WPCS: XSS okay.
				endif;
				?>

			<?php else : ?>

				<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'bigbox' ); ?></p>

			<?php endif; ?>
		</div>

		<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

			<div id="review_form_wrapper">
				<div id="review_form">
					<?php
					$commenter = wp_get_current_commenter();

					$comment_form = [
						'title_reply'         => __( 'Write a customer review', 'bigbox' ),
						/* translators: %s Product title. */
						'title_reply_to'      => __( 'Write a customer review for %s', 'bigbox' ),
						'title_reply_before'  => '<h2 id="reply-title" class="comment-reply-title">',
						'title_reply_after'   => '</h2>',
						'comment_notes_after' => '',
						'fields'              => [
							'author' => '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'bigbox' ) . ' <span class="required">*</span></label> ' .
										'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></p>',
							'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'bigbox' ) . ' <span class="required">*</span></label> ' .
										'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></p>',
						],
						'label_submit'        => esc_html__( 'Submit Review', 'bigbox' ),
						'logged_in_as'        => '',
						'comment_field'       => '',
					];

					$account_page_url = wc_get_page_permalink( 'myaccount' );

					if ( $account_page_url ) {
						/* translators: %s Account page URL. */
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'bigbox' ), esc_url( $account_page_url ) ) . '</p>';
					}

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'bigbox' ) . '</label><select name="rating" id="rating" required>
								<option value="">' . esc_html__( 'Rate&hellip;', 'bigbox' ) . '</option>
								<option value="5">' . esc_html__( 'Perfect', 'bigbox' ) . '</option>
								<option value="4">' . esc_html__( 'Good', 'bigbox' ) . '</option>
								<option value="3">' . esc_html__( 'Average', 'bigbox' ) . '</option>
								<option value="2">' . esc_html__( 'Not that bad', 'bigbox' ) . '</option>
								<option value="1">' . esc_html__( 'Very poor', 'bigbox' ) . '</option>
							</select></div>';
					}

						$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'bigbox' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

						comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
					?>
				</div>
			</div>

		<?php else : ?>

			<p class="card woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'bigbox' ); ?></p>

		<?php endif; ?>
	</div>

	<div class="woocommerce-reviews__info">
		<?php
		wc_get_template(
			'single-product/review-breakdown.php',
			[
				'product' => $product,
			]
		);

		dynamic_sidebar( 'shop-comments' );
		?>
	</div>

</div>

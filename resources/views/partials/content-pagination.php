<?php
/**
 * Blog pagination.
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

the_posts_pagination(
	[
		'next_text'          => esc_html__( 'Next Page', 'bigbox' ) . bigbox_get_svg( [ 'icon' => 'arrow-right' ] ),
		'prev_text'          => bigbox_get_svg( [ 'icon' => 'arrow-left' ] ) . esc_html__( 'Previous Page', 'bigbox' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'bigbox' ) . ' </span>',
	]
);

<?php
/**
 * Starter content.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */

// An annoying hack to ensure we can always importer starter content.
// @phpcs:disable
if ( isset( $_GET['starter-content-redirect'] ) ) {
	update_option( 'fresh_site', 1 );

	wp_safe_redirect(
		esc_url_raw(
			add_query_arg(
				[
					'walkthrough'     => isset( $_GET['walkthrough'] ),
					'starter-content' => isset( $_GET['starter-content'] ),
				], admin_url( 'customize.php' )
			)
		)
	);

	exit();
}
// @phpcs:enable

/**
 * Starter content.
 *
 * @since 1.0.0
 */
function bigbox_add_starter_content() {
	add_theme_support( 'starter-content', bigbox_get_starter_content() );
}
add_action( 'after_setup_theme', 'bigbox_add_starter_content' );

/**
 * Get starter content.
 *
 * @since 1.0.0
 *
 * @return array
 */
function bigbox_get_starter_content() {
	$starter_content = [
		'posts'     => [
			'home',
			'blog',
		],

		// Default to a static front page and assign the front and posts pages.
		'options'   => [
			'show_on_front'  => 'page',
			'page_on_front'  => '{{home}}',
			'page_for_posts' => '{{blog}}',
		],

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => [
			'primary'   => [
				'name'  => 'Primary',
				'items' => [
					'home' => [
						'type'      => 'post_type',
						'object'    => 'page',
						'object_id' => '{{home}}',
					],
				],
			],
			'secondary' => [
				'name'  => 'secondary',
				'items' => [
					'blog' => [
						'type'      => 'post_type',
						'object'    => 'page',
						'object_id' => '{{blog}}',
					],
				],
			],
		],
	];

	/**
	 * Filters starter content used for fresh installs.
	 *
	 * @since 1.0.0
	 *
	 * @param array $content The base content that does not plugins.
	 */
	return apply_filters( 'bigbox_get_starter_content', $starter_content );
}

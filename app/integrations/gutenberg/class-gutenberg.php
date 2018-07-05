<?php
/**
 * Gutenberg integration.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

namespace BigBox\Integration;

use BigBox\Integration;
use BigBox\Registerable;
use BigBox\Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Gutenberg.
 *
 * @since 1.0.0
 */
class Gutenberg extends Integration implements Registerable, Service {

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'after_setup_theme', [ $this, 'add_theme_support' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ] );
	}

	/**
	 * Declare view support for Gutenberg.
	 *
	 * @since 1.0.0
	 */
	public function add_theme_support() {
		add_theme_support( 'align-wide' );
		add_theme_support( 'wp-block-styles' );

		$palette = [];
		$colors  = bigbox_get_theme_colors();

		foreach ( $colors as $mod => $color ) {
			$palette[] = [
				'name'  => $color['name'],
				'slug'  => $mod,
				'color' => bigbox_get_theme_color( $mod ),
			];
		}

		add_theme_support( 'editor-color-palette', $palette );
	}

	/**
	 * Enqueue custom styless to make blocks match the frontend.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_block_editor_assets() {
		$version    = bigbox_get_theme_version();
		$stylesheet = bigbox_get_theme_name();

		// Load Google fonts if needed.
		$google = bigbox_get_google_fonts_url();

		if ( $google ) {
			wp_enqueue_style( $stylesheet . '-fonts', $google );
		}

		wp_enqueue_style( $stylesheet . '-gutenberg', get_template_directory_uri() . '/public/css/gutenberg.min.css', [], $version );

		/**
		 * This filter is documented in app/theme/assets.php
		 */
		if ( apply_filters( 'bigbox_customize_css_inline', true ) ) {
			wp_add_inline_style( $stylesheet . '-gutenberg', $this->inline_css() );
		}
	}

	/**
	 * Build inline CSS string.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private function inline_css() {
		$css = new \BigBox\Customize\Build_Inline_CSS();

		$colors = bigbox_get_theme_colors();

		$gray200 = bigbox_get_theme_color( 'gray-200' );
		$gray700 = bigbox_get_theme_color( 'gray-700' );
		$gray800 = bigbox_get_theme_color( 'gray-800' );

		$family      = bigbox_get_theme_font_family();
		$size        = get_theme_mod( 'type-font-size', 1 );
		$weight_base = bigbox_get_theme_font_weight( 'base' );
		$weight_bold = bigbox_get_theme_font_weight( 'bold' );

		$css->add(
			[
				'selectors'    => [
					'.editor-post-title .editor-post-title__input',
					'.edit-post-visual-editor',
					'.edit-post-visual-editor p',
				],
				'declarations' => [
					'color'       => esc_attr( $gray700 ),
					'font-family' => '"' . esc_attr( $family ) . '"',
					'font-weight' => $weight_base,
				],
			]
		);

		$css->add(
			[
				'selectors'    => [
					'.editor-post-title .editor-post-title__input',
				],
				'declarations' => [
					'font-weight' => $weight_bold,
				],
			]
		);

		$css->add(
			[
				'selectors'    => [
					'.editor-post-title__block > div',
				],
				'declarations' => [
					'border-bottom' => '2px solid ' . esc_attr( $gray200 ),
				],
			]
		);

		$css->add(
			[
				'selectors'    => [
					'.edit-post-visual-editor',
					'.edit-post-visual-editor p',
					'.edit-post-visual-editor .editor-default-block-appender input[type=text].editor-default-block-appender__content',
				],
				'declarations' => [
					'font-size' => ( $size * 16 ) . 'px',
				],
			]
		);

		$css->add(
			[
				'selectors'    => [
					'.edit-post-visual-editor h1',
					'.edit-post-visual-editor h2',
					'.edit-post-visual-editor h3',
					'.edit-post-visual-editor h4',
					'.edit-post-visual-editor h5',
					'.edit-post-visual-editor h6',
					'.edit-post-visual-editor label',
					'.edit-post-visual-editor mark',
					'.edit-post-visual-editor table tfoot td',
					'.edit-post-visual-editor strong',
					'.edit-post-visual-editor .wp-block-cover-image-text',
				],
				'declarations' => [
					'font-weight' => esc_attr( $weight_bold ),
				],
			]
		);

		$css->add(
			[
				'selectors'    => [
					'.editor-post-title .editor-post-title__input',
					'.edit-post-visual-editor a',
				],
				'declarations' => [
					'color' => esc_attr( $gray800 ),
				],
			]
		);

		// Dynamic color classes.
		foreach ( $colors as $color => $data ) {
			$css->add(
				[
					'selectors'    => [
						".edit-post-visual-editor p.has-{$color}-background-color",
						".edit-post-visual-editor .wp-block-button .wp-block-button__link.has-{$color}-background-color",
					],
					'declarations' => [
						'background-color' => esc_attr( bigbox_get_theme_color( $color ) ),
					],
				]
			);

			$css->add(
				[
					'selectors'    => [
						".edit-post-visual-editor p.has-{$color}-color",
						".edit-post-visual-editor p.has-{$color}-color a",
						".edit-post-visual-editor .wp-block-button .wp-block-button__link.has-{$color}-color",
					],
					'declarations' => [
						'color' => esc_attr( bigbox_get_theme_color( $color ) ),
					],
				]
			);
		}

		return $css->build();
	}

}

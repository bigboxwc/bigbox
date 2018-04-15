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
		add_theme_support( 'gutenberg' );
		add_theme_support( 'align-wide' );

		$colors = bigbox_get_theme_colors();

		foreach ( array_merge( $colors['scheme'], $colors['grays'] ) as $color => $data ) {
			$scheme[] = bigbox_get_theme_color( $color );
		}

		add_theme_support( 'editor-color-palette', ...$scheme );

		// Cusstom logo support.
		add_theme_support(
			'custom-logo', [
				'flex-width'  => true,
				'header-text' => true,
			]
		);
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

		// Basic dynamic styles.
		$css = new \BigBox\Customize\Build_Inline_CSS();

		$gray700 = bigbox_get_theme_color( 'gray-700' );
		$gray800 = bigbox_get_theme_color( 'gray-800' );
		$family  = bigbox_get_theme_font_family();

		$css->add( [
			'selectors'    => [
				'.edit-post-visual-editor',
				'.edit-post-visual-editor p',
				'.editor-post-title .editor-post-title__input',
			],
			'declarations' => [
				'font-family' => esc_attr( $family ),
				'color'       => esc_attr( $gray700 ),
			],
		] );

		$css->add( [
			'selectors'    => [
				'.blocks-rich-text__tinymce a',
				'.editor-post-title .editor-post-title__input',
			],
			'declarations' => [
				'color' => esc_attr( $gray800 ),
			],
		] );

		wp_add_inline_style( $stylesheet . '-gutenberg', $css->build() );
	}

}

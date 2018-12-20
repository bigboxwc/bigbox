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
	 * Additional inline CSS configuration items.
	 *
	 * @var array $inline_css_configs
	 * @since 1.16.0
	 */
	protected $inline_css_configs = [
		'colors',
	];

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_filter( 'bigbox_customize_inline_css_configs', [ $this, 'inline_css_configs' ] );
		add_action( 'after_setup_theme', [ $this, 'add_theme_support' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ] );

		/**
		 * This filter is documented in app/theme/assets.php
		 */
		if ( apply_filters( 'bigbox_customize_css_inline', true ) ) {
			add_filter( 'block_editor_settings', [ $this, 'inline_editor_css' ], 9999 );
		}
	}

	/**
	 * Declare view support for Gutenberg.
	 *
	 * @since 1.0.0
	 */
	public function add_theme_support() {
		add_theme_support( 'align-wide' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );

		// Add editor style.
		add_editor_style( 'public/css/gutenberg.min.css' );

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

		$sizes = [
			[
				'name'      => __( 'Extra Small', 'bigbox' ),
				'shortName' => __( 'XS', 'bigbox' ),
				'size'      => 12,
				'slug'      => 'xs',
			],
			[
				'name'      => __( 'Small', 'bigbox' ),
				'shortName' => __( 'S', 'bigbox' ),
				'size'      => 14,
				'slug'      => 'sm',
			],
			[
				'name'      => __( 'Normal', 'bigbox' ),
				'shortName' => __( 'M', 'bigbox' ),
				'size'      => 16,
				'slug'      => 'base',
			],
			[
				'name'      => __( 'Large', 'bigbox' ),
				'shortName' => __( 'L', 'bigbox' ),
				'size'      => 20,
				'slug'      => 'lg',
			],
			[
				'name'      => __( 'Extra Large', 'bigbox' ),
				'shortName' => __( 'XL', 'bigbox' ),
				'size'      => 26,
				'slug'      => 'xl',
			],
		];

		add_theme_support( 'editor-font-sizes', $sizes );
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
			wp_enqueue_style( $stylesheet . '-fonts', $google, [], $version );
		}
	}

	/**
	 * Build inline CSS string for the backend editor.
	 *
	 * Attaches to the editor settings so the CSS is wrapped by the editor
	 * for matched specificity.
	 *
	 * @since 1.16.0
	 *
	 * @param array $settings Editor settings.
	 * @return array
	 */
	public function inline_editor_css( $settings ) {
		$css = new \BigBox\Customize\Build_Inline_CSS();

		$colors = bigbox_get_theme_colors();

		$gray200 = bigbox_get_theme_color( 'gray-200' );
		$gray700 = bigbox_get_theme_color( 'gray-700' );
		$gray800 = bigbox_get_theme_color( 'gray-800' );

		$family      = bigbox_get_theme_font_family();
		$size        = get_theme_mod( 'type-font-size', 1 );
		$weight_base = bigbox_get_theme_font_weight( 'base' );
		$weight_bold = bigbox_get_theme_font_weight( 'bold' );

		$config = [];

		// Base.
		$config[] = [
			'selectors'    => [
				'body',
				'.editor-post-title__block .editor-post-title__input',
			],
			'declarations' => [
				'color'       => esc_attr( $gray700 ),
				'font-size'   => ( $size * 16 ) . 'px',
				'font-family' => esc_attr( $family ),
				'font-weight' => $weight_base,
			],
		];

		// Title.
		$config[] = [
			'selectors'    => [
				'.editor-post-title__block .editor-post-title__input',
			],
			'declarations' => [
				'font-weight'   => $weight_bold,
				'font-size'     => ( $size * 1.65 ) . 'em',
				'border-bottom' => '2px solid ' . esc_attr( $gray200 ),
			],
		];

		// Bold items.
		$config[] = [
			'selectors'    => [
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
				'label',
				'mark',
				'table tfoot td',
				'strong',
				'wp-block-cover-text',
			],
			'declarations' => [
				'font-weight' => esc_attr( $weight_bold ),
			],
		];

		// Darker items.
		$config[] = [
			'selectors'    => [
				'.editor-post-title__block .editor-post-title__input',
				'a',
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
			],
			'declarations' => [
				'color' => esc_attr( $gray800 ),
			],
		];

		foreach ( $config as $x => $items ) {
			$css->add( $config[ $x ] );
		}

		$settings['styles'][] = [
			'baseUrl' => null,
			'css'     => $css->build(),
		];

		return $settings;
	}
}

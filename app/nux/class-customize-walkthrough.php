<?php
/**
 * A better way to use starter content.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */

namespace BigBox\NUX;

use BigBox\ThemeFactory;
use BigBox\Registerable;
use BigBox\Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Starter content.
 *
 * @since 1.0.0
 */
class Customize_Walkthrough implements Registerable, Service {

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_filter( 'bigbox_get_starter_content', [ $this, 'filter_starter_content' ], 99 );
		add_action( 'customize_controls_print_scripts', [ $this, 'customize_controls_print_scripts' ] );
		add_filter( 'bigbox_customize_controls_js', [ $this, 'bigbox_customize_controls_js' ] );
	}

	/**
	 * Unset starter content if option is not checked.
	 *
	 * @since 1.0.0
	 *
	 * @param array $content Starter content.
	 * @return array
	 */
	public function filter_starter_content( $content ) {
		if ( ! isset( $_GET['starter-content'] ) || 1 !== absint( $_GET['starter-content'] ) ) {
			$content = null;
		}

		return $content;
	}

	/**
	 * Output walkthrough pointers.
	 *
	 * @since 1.0.0
	 */
	public function customize_controls_print_scripts() {
		wp_enqueue_style( 'wp-pointer' );
	}

	/**
	 * Add walkthrough specific items to scripts.
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings Settings
	 * @return array
	 */
	public function bigbox_customize_controls_js( $settings ) {
		$pointers = [
			[
				'el'      => '#customize-info',
				'title'   => esc_html__( '📦 Welcome to BigBox', 'bigbox' ),
				'content' => 'hi',
			],
		];

		$settings['walkthrough'] = [
			'active'   => isset( $_GET['walkthrough'] ),
			'template' => bigbox_get_view( 'nux/pointer' ),
			'pointers' => $pointers,
		];

		return $settings;
	}
}

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

		if ( isset( $_GET['walkthrough'] ) ) { // @codingStandardsIgnoreLine
			add_action( 'customize_controls_print_footer_scripts', [ $this, 'customize_controls_print_footer_scripts' ] );
			add_filter( 'bigbox_customize_controls_js', [ $this, 'bigbox_customize_controls_js' ] );
		}
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
		if ( ! isset( $_GET['starter-content'] ) || 1 !== absint( $_GET['starter-content'] ) ) { // @codingStandardsIgnoreLine
			$content = null;
		}

		return $content;
	}

	/**
	 * Output pointer template.
	 *
	 * @since 1.0.0
	 */
	public function customize_controls_print_footer_scripts() {
		bigbox_view( 'nux/pointer' );
	}

	/**
	 * Add walkthrough specific items to scripts.
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings Settings.
	 * @return array
	 */
	public function bigbox_customize_controls_js( $settings ) {
		$pointers = [
			'welcome' => [
				'el'      => '#customize-info',
				'title'   => esc_html__( '📦 Welcome to BigBox', 'bigbox' ),
				'content' => esc_html__( 'Need some help getting started? No problem! I can guide you through the Customization options and get you on your way.', 'bigbox' ),
			],
			'logo'    => [
				'el'        => '#customize-control-custom_logo',
				'title'     => esc_html__( 'Add a Custom Logo', 'bigbox' ),
				'content'   => esc_html__( 'Update your website\'s identity to reflect your unique brand.', 'bigbox' ),
				'focusType' => 'control',
				'focus'     => 'custom_logo',
			],
			'colors'  => [
				'el'        => '#customize-control-color-primary',
				'title'     => esc_html__( 'Choose Your Color Scheme', 'bigbox' ),
				'content'   => esc_html__( 'Select the colors used to generate various parts of your website.', 'bigbox' ),
				'focusType' => 'control',
				'focus'     => 'color-primary',
			],
			'type'    => [
				'el'        => '#customize-control-type-font-family',
				'title'     => esc_html__( 'Chose Your Typography', 'bigbox' ),
				'content'   => esc_html__( 'Select the font family and weights used throughout your website.', 'bigbox' ),
				'focusType' => 'section',
				'focus'     => 'type',
			],
			'widgets' => [
				'el'        => '#sub-accordion-section-sidebar-widgets-shop li:first-child .customize-section-title',
				'title'     => esc_html__( 'Adjust Your Widgets', 'bigbox' ),
				'content'   => esc_html__( 'Modify the widgets used on your shop page to fit your needs.', 'bigbox' ),
				'focusType' => 'section',
				'focus'     => 'sidebar-widgets-shop',
			],
			'end'     => [
				'el'        => '#customize-control-custom_logo',
				'title'     => esc_html__( 'All Set!', 'bigbox' ),
				'content'   => esc_html__( 'Continue customizing your site as much as you would like. You can always come back by visiting Appearance ▸ Customize', 'bigbox' ),
				'focusType' => 'control',
				'focus'     => 'custom_logo',
			],
		];

		if ( ! isset( $_GET['starter-content'] ) ) { // @codingStandardsIgnoreLine
			unset( $pointers['widgets'] );
		}

		/**
		 * Allows pointers to be added or removed.
		 *
		 * @since 1.5.0
		 *
		 * @param array $pointers Registered pointers.
		 * @return array
		 */
		$pointers = apply_filters( 'bigbox_customize_walkthrough_pointers', $pointers );

		$settings['walkthrough'] = [
			'active'   => isset( $_GET['walkthrough'] ), // @codingStandardsIgnoreLine
			'pointers' => array_values( $pointers ),
		];

		return $settings;
	}
}

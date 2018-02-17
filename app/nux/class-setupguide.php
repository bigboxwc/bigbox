<?php
/**
 * New user experience setup guide.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Integration
 * @author Spencer Finnell
 */

namespace BigBox\NUX;

use BigBox\Registerable;
use BigBox\Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Setup guide.
 *
 * @since 1.0.0
 */
class SetupGuide implements Registerable, Service {

	/**
	 * Steps to use for guide meta boxes.
	 *
	 * @var array $steps Steps to use for meta boxes.
	 */
	protected $steps;

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->steps = [
			'activate'        => [
				'label'     => __( 'Enable Automatic Updates', 'bigbox' ),
				'completed' => false,
			],
			'install-plugins' => [
				'label'     => __( 'Install Plugins', 'bigbox' ),
				'completed' => false,
			],
		];

		add_action( 'admin_menu', [ $this, 'add_menu_item' ] );
		add_action( 'admin_menu', [ $this, 'add_meta_boxes' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
	}

	/**
	 * Add a menu page to hold the setup guide.
	 *
	 * @since 1.0.0
	 */
	public function add_menu_item() {
		add_menu_page(
			__( 'BigBox', 'bigbox' ),
			__( 'BigBox', 'bigbox' ),
			'edit_theme_options',
			'bigbox',
			[ $this, 'output_page' ],
			''
		);
	}

	/**
	 * Add a metabox for each step.
	 *
	 * @since 1.0.0
	 */
	public function add_meta_boxes() {
		foreach ( $this->steps as $key => $step ) {
			add_meta_box(
				$key,
				esc_html( $step['label'] ),
				[ $this, 'step' ],
				'bigbox-setup-steps',
				'normal',
				'high',
				array_merge( [ 'step' => $key ], $step )
			);
		}
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {
		wp_register_style( 'bigbox-nux', get_template_directory_uri() . '/public/css/nux.min.css' );
		wp_register_script( 'bigbox-nux', get_template_directory_uri() . '/public/js/nux.min.js' );

		wp_localize_script( 'bigbox-nux', 'BigBoxNUX', [
			'domain'   => home_url( '/' ),
			'itemName' => 'BigBox WooCommerce Theme',
		] );
	}

	/**
	 * Output page contents.
	 *
	 * @since 1.0.0
	 */
	public function output_page() {
		bigbox_view( 'nux/admin-page' );
	}

	/**
	 * Output step content.
	 *
	 * @since 1.0.0
	 *
	 * @param null  $null Null.
	 * @param array $metabox Current metabox arguments.
	 */
	public function step( $null, $metabox ) {
		bigbox_view( 'nux/step-' . $metabox['args']['step'], [
			'step' => $metabox['args'],
		] );
	}

}

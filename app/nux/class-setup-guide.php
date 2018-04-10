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

use BigBox\ThemeFactory;
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
class Setup_Guide implements Registerable, Service {

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
			'license-manager' => [
				'label'    => __( 'Enable Automatic Updates', 'bigbox' ),
				'priority' => 10,
			],
			'install-plugins' => [
				'label'    => __( 'Optimize Your Website', 'bigbox' ),
				'priority' => 30,
			],
			'customize'       => [
				'label'    => __( 'Customize Appearance', 'bigbox' ),
				'priority' => 40,
			],
		];

		if ( ! bigbox_is_integration_active( 'woocommerce' ) ) {
			$this->steps['install-woocommerce'] = [
				'label'    => __( 'Install WooCommerce', 'bigbox' ),
				'priority' => 20,
			];
		}

		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'admin_menu', [ $this, 'add_menu_item' ] );
		add_action( 'admin_menu', [ $this, 'add_meta_boxes' ], 20 );
	}

	/**
	 * Get steps.
	 *
	 * Public entrance for further filtering.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_steps() {
		$steps = apply_filters( 'bigbox_setup_guide_steps', $this->steps );

		uasort(
			$steps, function( $a, $b ) {
				if ( $a['priority'] === $b['priority'] ) {
					return 0;
				}

				return $a['priority'] < $b['priority'] ? -1 : 1;
			}
		);

		return $steps;
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {
		wp_register_style( 'bigbox-nux', get_template_directory_uri() . '/public/css/nux.min.css' );
	}

	/**
	 * Add a menu page to hold the setup guide.
	 *
	 * @since 1.0.0
	 */
	public function add_menu_item() {
		add_theme_page(
			esc_html__( 'BigBox', 'bigbox' ),
			esc_html__( 'BigBox', 'bigbox' ),
			'edit_theme_options',
			'bigbox',
			[ $this, 'output_page' ],
			'dashicons-store'
		);
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
	 * Add a metabox for each step.
	 *
	 * @since 1.0.0
	 */
	public function add_meta_boxes() {
		foreach ( $this->get_steps() as $key => $step ) {
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
	 * Output step content.
	 *
	 * @since 1.0.0
	 *
	 * @param null  $null Null.
	 * @param array $metabox Current metabox arguments.
	 */
	public function step( $null, $metabox ) {
		bigbox_view(
			'nux/steps/' . $metabox['args']['step'], [
				'step' => $metabox['args'],
			]
		);
	}

}

<?php
/**
 * New user experience setup guide.
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
		require_once get_template_directory() . '/app/nux/utils.php';

		$this->steps = [
			'license-manager' => [
				'label'    => __( 'Enable Automatic Updates', 'bigbox' ),
				'priority' => 10,
			],
			'customize'       => [
				'label'    => __( 'Customize Your Store', 'bigbox' ),
				'priority' => 30,
			],
			'install-plugins' => [
				'label'    => __( 'Optimize Your Store', 'bigbox' ),
				'priority' => 40,
			],
		];

		// Dirty check.
		if (
			! bigbox_is_integration_active( 'woocommerce' ) ||
			! get_option( 'woocommerce_shop_page_id', false )
		) {
			$this->steps['install-woocommerce'] = [
				'label'    => __( 'Setup WooCommerce', 'bigbox' ),
				'priority' => 20,
			];
		}

		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'admin_menu', [ $this, 'add_menu_item' ] );
		add_action( 'admin_menu', [ $this, 'add_meta_boxes' ], 20 );

		// Redirect on fresh install.
		if ( defined( 'WP_DEBUG' ) && ! WP_DEBUG ) {
			add_action( 'after_switch_theme', [ $this, 'redirect_on_activation' ] );
			add_action( 'wp_ajax_bigbox_notice_dismiss_license_reminder', [ $this, 'dismiss_add_license_reminder' ] );
		}
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
		/**
		 * Filters the NUX setup guide steps.
		 *
		 * @since 1.0.0
		 *
		 * @param array Setup guide steps.
		 */
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
		$version = bigbox_get_theme_version();

		wp_register_style( 'bigbox-nux', get_template_directory_uri() . '/public/css/nux.min.css', [], $version );
	}

	/**
	 * Add a menu page to hold the setup guide.
	 *
	 * @since 1.0.0
	 */
	public function add_menu_item() {
		add_theme_page(
			'BigBox',
			'BigBox',
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

	/**
	 * Redirect on activation.
	 *
	 * @since 1.0.0
	 */
	public function redirect_on_activation() {
		$version     = bigbox_get_theme_version();
		$option_name = bigbox_get_theme_name() . '_version';

		// Just update version if not fresh.
		if ( get_option( $option_name, false ) ) {
			update_option( $option_name, $version );

			return;
		}

		// @codingStandardsIgnoreStart
		if ( isset( $_GET['action'] ) ) {
			unset( $_GET['action'] );
		}
		// @codingStandardsIgnoreEnd

		// Attempt to install and activate WooCommerce.
		( new Install_Plugin() )->data(
			[
				'slug'   => 'woocommerce',
				'plugin' => [
					'slug' => 'woocommerce',
					'file' => 'woocommerce.php',
				],
			]
		)->dispatch();

		// Schedule a notice to show in a week if they haven't added their key.
		wp_clear_scheduled_hook( 'bigbox_nux_show_add_license_reminder' );
		wp_schedule_single_event( ( time() + WEEK_IN_SECONDS ), 'bigbox_nux_show_add_license_reminder' );

		// Update version.
		update_option( $option_name, $version );

		// Redirect.
		wp_safe_redirect( esc_url( add_query_arg( 'page', 'bigbox', admin_url( 'themes.php' ) ) ) );
		exit();
	}

	/**
	 * Persist the license reminder notice dismissal.
	 *
	 * @since 1.0.0
	 */
	public function dismiss_add_license_reminder() {
		check_ajax_referer( 'bigbox_notice_dismiss_license_reminder', 'security' );
		add_option( 'bigbox_notice_dismiss_license_reminder', true );
		wp_send_json_success();
	}
}

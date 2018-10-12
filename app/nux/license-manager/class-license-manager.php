<?php
/**
 * License manager and automatic updates.
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
 * License manager.
 *
 * @since 1.0.0
 */
class License_Manager implements Registerable, Service {

	/**
	 * API URL to query against.
	 *
	 * @var string $remote_api_url
	 */
	private $remote_api_url;

	/**
	 * Theme slug.
	 *
	 * @var string $theme_slug
	 */
	private $theme_slug;

	/**
	 * Current license skey.
	 *
	 * @var string $license_key
	 */
	private $license_key;

	/**
	 * Current theme version.
	 *
	 * @var string $version
	 */
	private $version;

	/**
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$this->license        = get_option( 'bigbox_license', '' );
		$this->license_status = get_option( 'bigbox_license_status', 'invalid' );

		$this->item_name      = 'BigBox WooCommerce Theme';
		$this->version        = bigbox_get_theme_version();
		$this->theme_slug     = 'bigbox';
		$this->remote_api_url = 'https://bigboxwc.com/';

		// Register automatic updater with args.
		( new License_Manager\Theme_Updater() )->register(
			[
				'license'        => $this->license,
				'item_name'      => $this->item_name,
				'version'        => $this->version,
				'theme_slug'     => $this->theme_slug,
				'remote_api_url' => $this->remote_api_url,
			]
		);

		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'wp_ajax_bigbox-license-request', [ $this, 'activate_or_deactivate_license' ] );

		register_setting(
			'general',
			'bigbox_license',
			[
				'sanitize_callback' => 'esc_attr',
				'show_in_rest'      => true,
				'type'              => 'string',
				'default'           => 'public',
			]
		);

		register_setting(
			'general',
			'bigbox_license_status',
			[
				'sanitize_callback' => 'esc_attr',
				'show_in_rest'      => true,
				'type'              => 'string',
				'default'           => 'public',
			]
		);
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {
		$version = bigbox_get_theme_version();

		wp_register_script( 'bigbox-license-manager', get_template_directory_uri() . '/public/js/license-manager.min.js', [ 'wp-api', 'wp-util', 'wp-backbone' ], $version, true );

		wp_localize_script(
			'bigbox-license-manager',
			'BigBoxLicenseManager',
			[
				'nonce' => wp_create_nonce( 'bigbox-license-request' ),
				'local' => [
					'license' => $this->license,
					'isValid' => 'valid' === $this->license_status,
				],
				'i18n'  => [
					'licenseValid'   => esc_html__( 'Valid', 'bigbox' ),
					'licenseInvalid' => esc_html__( 'Inactive: not receiving automatic updates notifications.', 'bigbox' ),
				],
			]
		);
	}

	/**
	 * Makes a call to the API.
	 *
	 * @since 1.0.0
	 *
	 * @param array $api_params to be used for wp_remote_get.
	 * @return array $response decoded JSON response.
	 */
	protected function get_api_response( $api_params ) {
		$response = wp_remote_post(
			$this->remote_api_url,
			[
				'timeout' => 5,
				'body'    => $api_params,
			]
		);

		return $response;
	}

	/**
	 * Make a server request to the API to retrieve license data.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function activate_or_deactivate_license() {
		// @phpcs:disable
		if ( ! check_ajax_referer( 'bigbox-license-request', '_wpnonce', false ) ) {
			return wp_send_json_error();
		}

		$license = esc_attr( $_POST['license'] );
		$action  = esc_attr( $_POST['edd_action'] );
		// @phpcs:enable

		if ( ! in_array( $action, [ 'activate_license', 'deactivate_license' ], true ) ) {
			return wp_send_json_error();
		}

		$api_params = [
			'edd_action' => $action,
			'license'    => $license,
			'item_name'  => $this->item_name,
			'url'        => home_url( '/' ),
		];

		$response = $this->get_api_response( $api_params );

		if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// Store license information.
			if ( 'activate_license' === $action ) {
				$valid = ! isset( $license_data->error );

				update_option( 'bigbox_license', $license );
				update_option( 'bigbox_license_status', $valid ? 'valid' : 'invalid' );

				return wp_send_json_success(
					[
						'isValid' => $valid,
						'license' => $license,
					]
				);
				// Clear license information.
			} else {
				update_option( 'bigbox_license', '' );
				update_option( 'bigbox_license_status', 'invalid' );

				return wp_send_json_success(
					[
						'isValid' => false,
						'license' => '',
					]
				);
			}
		}

		wp_send_json_error();
	}

}

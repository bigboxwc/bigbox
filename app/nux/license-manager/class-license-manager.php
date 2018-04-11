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
		$this->item_name      = 'BigBox WooCommerce Theme';
		$this->version        = bigbox_get_theme_version();
		$this->theme_slug     = 'bigbox';
		$this->remote_api_url = 'https://bigbox.dev/';

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

		register_setting(
			'general', 'bigbox_license', [
				'sanitize_callback' => 'esc_attr',
				'show_in_rest'      => true,
				'type'              => 'string',
				'default'           => 'public',
			]
		);

		register_setting(
			'general', 'bigbox_license_status', [
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
		wp_register_script( 'bigbox-license-manager', get_template_directory_uri() . '/public/js/license-manager.min.js', [ 'wp-api' ] );
		wp_localize_script(
			'bigbox-license-manager', 'BigBoxLicenseManager', [
				'remote' => [
					'apiRoot'  => $this->remote_api_url,
					'itemName' => $this->item_name,
				],
				'local'  => [
					'license' => $this->license,
					'domain'  => home_url( '/' ),
				],
				'i18n'   => [
					'licensePlaceholder' => esc_html__( 'Enter license key...', 'bigbox' ),
					'licenseSubmit'      => esc_html__( 'Activate License', 'bigbox' ),
					'licenseLabel'       => esc_html__( 'License Status', 'bigbox' ),
					'licenseValid'       => esc_html__( 'Valid', 'bigbox' ),
					'licenseInvalid'     => esc_html__( 'Inactive: not receiving automatic updates notifications.', 'bigbox' ),
					'licenseDeactivate'  => esc_html__( 'Deactivate', 'bigbox' ),
				],
			]
		);
	}

}

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
	 * Connect to WordPress.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

		register_setting( 'general', 'bigbox_license', [
			'sanitize_callback' => 'esc_attr',
			'show_in_rest'      => true,
			'type'              => 'string',
			'default'           => 'public',
		] );
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {
		wp_register_script( 'bigbox-license-manager', get_template_directory_uri() . '/public/js/license-manager.min.js', [ 'wp-api' ] );
		wp_localize_script( 'bigbox-license-manager', 'BigBoxLicenseManager', [
			'remote' => [
				'apiRoot'  => 'https://bigbox.dev/',
				'itemName' => 'BigBox WooCommerce Theme',
			],
			'local'  => [
				'license' => get_option( 'bigbox_license', '' ),
				'domain'  => home_url( '/' ),
			],
			'i18n'   => [
				'licensePlaceholder' => esc_html__( 'Enter license key...', 'bigbox' ),
				'licenseSubmit'      => esc_html__( 'Activate License', 'bigbox' ),
				'licenseLabel'       => esc_html__( 'License', 'bigbox' ),
				'licenseValid'       => esc_html__( 'Valid', 'bigbox' ),
				'licenseInvalid'     => esc_html__( 'Invalid', 'bigbox' ),
			],
		] );
	}

}

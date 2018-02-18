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

namespace BigBox\NUX\License_Manager;

use BigBox\Registerable;
use BigBox\Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme updater.
 *
 * @since 1.0.0
 */
class Theme_Updater implements Registerable, Service {

	/**
	 * API URL to query against.
	 *
	 * @var string $remote_api_url
	 */
	private $remote_api_url;
	private $request_data;
	private $response_key;
	private $theme_slug;
	private $license_key;
	private $version;
	private $author;

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
		$this->author         = 'Spencer Finnell';
		$this->beta           = false;
		$this->remote_api_url = 'https://bigbox.dev/';
		$this->response_key   = 'bigbox-update-response';

		add_filter( 'site_transient_update_themes', [ $this, 'theme_update_transient' ] );
		add_filter( 'delete_site_transient_update_themes', [ $this, 'delete_theme_update_transient' ] );
		add_action( 'load-update-core.php', [ $this, 'delete_theme_update_transient' ] );
		add_action( 'load-themes.php', [ $this, 'delete_theme_update_transient' ] );
	}

	/**
	 * Update the theme update transient with the response from the version check
	 *
	 * @since 1.0.0
	 *
	 * @param  array $value   The default update values.
	 * @return array|boolean  If an update is available, returns the update parameters, if no update is needed returns false, if
	 *                        the request fails returns false.
	 */
	public function theme_update_transient( $value ) {
		$update_data = $this->check_for_update();

		if ( $update_data ) {
			$value->response[ $this->theme_slug ] = $update_data;
		}

		return $value;
	}

	/**
	 * Remove the update data for the theme
	 *
	 * @since 1.0.0
	 */
	public function delete_theme_update_transient() {
		delete_transient( $this->response_key );
	}

	/**
	 * Call the EDD SL API (using the URL in the construct) to get the latest version information
	 *
	 * @since 1.0.0
	 *
	 * @return array|boolean  If an update is available, returns the update parameters, if no update is needed returns false, if
	 *                        the request fails returns false.
	 */
	public function check_for_update() {
		$update_data = get_transient( $this->response_key );

		if ( false === $update_data ) {
			$failed = false;

			$api_params = [
				'edd_action' => 'get_version',
				'license'    => $this->license,
				'name'       => $this->item_name,
				'slug'       => $this->theme_slug,
				'version'    => $this->version,
				'author'     => $this->author,
				'beta'       => $this->beta,
			];

			$response = wp_remote_post(
				$this->remote_api_url,
				[
					'timeout' => 15,
					'body'    => $api_params,
				]
			);

			// Make sure the response was successful.
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				$failed = true;
			}

			$update_data = json_decode( wp_remote_retrieve_body( $response ) );

			if ( ! is_object( $update_data ) ) {
				$failed = true;
			}

			// If the response failed, try again in 30 minutes.
			if ( $failed ) {
				$data              = new \stdClass();
				$data->new_version = $this->version;

				set_transient( $this->response_key, $data, strtotime( '+30 minutes', current_time( 'timestamp' ) ) );

				return false;
			}

			// If the status is 'ok', return the update arguments.
			if ( ! $failed ) {
				$update_data->sections = maybe_unserialize( $update_data->sections );

				set_transient( $this->response_key, $update_data, strtotime( '+12 hours', current_time( 'timestamp' ) ) );
			}
		}

		if ( version_compare( $this->version, $update_data->new_version, '>=' ) ) {
			return false;
		}

		return (array) $update_data;
	}

}

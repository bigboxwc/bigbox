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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme updater.
 *
 * @since 1.0.0
 */
class Theme_Updater implements Registerable {

	/**
	 * Response key and transient key.
	 *
	 * @var string $response_key
	 */
	private $response_key;

	/**
	 * Arguments.
	 *
	 * @var array $args
	 */
	private $args;

	/**
	 * Connect to WordPress.
	 *
	 * @param array $args Extended arguments.
	 *
	 * @since 1.0.0
	 */
	public function register( $args = [] ) {
		// Disable on debug.
		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
			return true;
		}

		$this->response_key = 'bigbox-update-response';
		$this->args         = $args;

		add_filter( 'pre_set_site_transient_update_themes', [ $this, 'theme_update_transient' ] );
		add_filter( 'delete_site_transient_update_themes', [ $this, 'delete_theme_update_transient' ] );
		add_action( 'load-update-core.php', [ $this, 'delete_theme_update_transient' ] );
		add_action( 'load-themes.php', [ $this, 'delete_theme_update_transient' ] );
		add_filter( 'http_request_args', [ $this, 'disable_wporg_request' ], 5, 2 );

		add_action( 'admin_init', [ $this, 'add_menu_count' ] );
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
		if ( isset( $value->response[ $this->args['theme_slug'] ] ) ) {
			return $value;
		}

		$update_data = $this->check_for_update();

		if ( $update_data ) {
			$value->response[ $this->args['theme_slug'] ] = $update_data;
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

			$response = wp_remote_post(
				$this->args['remote_api_url'],
				[
					'timeout'   => 5,
					'body'      => [
						'edd_action' => 'get_version',
						'license'    => $this->args['license'],
						'name'       => $this->args['item_name'],
						'slug'       => $this->args['theme_slug'],
						'version'    => $this->args['version'],
						'beta'       => false,
					],
					'sslverify' => false,
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
				$update_data              = new \stdClass();
				$update_data->new_version = $this->args['version'];

				set_transient( $this->response_key, $update_data, strtotime( '+30 minutes', current_time( 'timestamp' ) ) );

				return false;
			} else {
				$update_data->sections = maybe_unserialize( $update_data->sections );

				set_transient( $this->response_key, $update_data, strtotime( '+12 hours', current_time( 'timestamp' ) ) );
			}
		}

		if ( version_compare( $this->args['version'], $update_data->new_version, '>=' ) ) {
			return false;
		}

		return (array) $update_data;
	}

	/**
	 * Add count to "Themes" menu item.
	 *
	 * @since 1.0.0
	 */
	public function add_menu_count() {
		global $submenu;

		$count = '';

		if ( ! is_multisite() && current_user_can( 'update_themes' ) ) {
			if ( ! isset( $update_data ) ) {
				$update_data = wp_get_update_data();

				if ( 0 !== $update_data['counts']['themes'] ) {
					$count = "<span class='update-plugins count-{$update_data['counts']['themes']}'><span class='theme-count'>" . number_format_i18n( $update_data['counts']['themes'] ) . '</span></span>';

					$submenu['themes.php'][5][0] = sprintf( _x( 'Themes %s', 'admin menu item update count', 'bigbox' ), $count ); // @codingStandardsIgnoreLine
				}
			}
		}
	}

	/**
	 * Disable requests to wp.org repository for this theme.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $request Request to .org.
	 * @param string $url URL to check.
	 * @return array
	 */
	public function disable_wporg_request( $request, $url ) {
		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
			return $request;
		}

		$themes = json_decode( $request['body']['themes'] );
		$parent = get_option( 'template' );
		$child  = get_option( 'stylesheet' );

		unset( $themes->themes->$parent );
		unset( $themes->themes->$child );

		$request['body']['themes'] = wp_json_encode( $themes );

		return $request;
	}

}

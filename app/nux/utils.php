<?php
/**
 * NUX utilities.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Remind people to enter a license key if they haven't after a week.
 *
 * @since 1.0.0
 */
function bigbox_nux_show_add_license_reminder() {
	// Only show to admins.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Do nothing if dismissed.
	if ( get_option( 'bigbox_notice_dismiss_license_reminder', false ) ) {
		return;
	}

	// Do nothing if already entered.
	if ( get_option( 'bigbox_license', false ) && 'valid' === get_option( 'bigbox_license_status' ) ) {
		return;
	}

	add_action(
		'admin_notices',

		/**
		 * Output the license reminder notice.
		 *
		 * @since 1.0.0
		 */
		function() {
			bigbox_view( 'nux/license-reminder' );
		}
	);
}

/**
 * Install a plugin from WordPress.org.
 *
 * @since 1.0.0
 *
 * @throws Exception If API cannot be reached or plugin cannot be installed.
 *
 * @param string $plugin_slug Slug of hosted plugin.
 * @param array  $plugin Extra plugin data that may not be able to be derived.
 */
function bigbox_install_plugin( $plugin_slug, $plugin ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	WP_Filesystem();

	$skin              = new Automatic_Upgrader_Skin();
	$upgrader          = new WP_Upgrader( $skin );
	$installed_plugins = array_reduce( array_keys( get_plugins() ), 'bigbox_associate_plugin_file', [] );
	$plugin_slug       = $plugin['slug'];
	$plugin_file       = isset( $plugin['file'] ) ? $plugin['file'] : $plugin_slug . '.php';
	$installed         = false;
	$activate          = false;

	// See if the plugin is installed already.
	if ( isset( $installed_plugins[ $plugin_file ] ) ) {
		$installed = true;
		$activate  = ! is_plugin_active( $installed_plugins[ $plugin_file ] );
	}

	// Install this thing!
	if ( ! $installed ) {
		// Suppress feedback.
		ob_start();

		try {
			$plugin_information = plugins_api(
				'plugin_information',
				[
					'slug'   => $plugin_slug,
					'fields' => [
						'short_description' => false,
						'sections'          => false,
						'requires'          => false,
						'rating'            => false,
						'ratings'           => false,
						'downloaded'        => false,
						'last_updated'      => false,
						'added'             => false,
						'tags'              => false,
						'homepage'          => false,
						'donate_link'       => false,
						'author_profile'    => false,
						'author'            => false,
					],
				]
			);

			if ( is_wp_error( $plugin_information ) ) {
				throw new Exception( $plugin_information->get_error_message() );
			}

			$package  = $plugin_information->download_link;
			$download = $upgrader->download_package( $package );

			if ( is_wp_error( $download ) ) {
				throw new Exception( $download->get_error_message() );
			}

			$working_dir = $upgrader->unpack_package( $download, true );

			if ( is_wp_error( $working_dir ) ) {
				throw new Exception( $working_dir->get_error_message() );
			}

			$result = $upgrader->install_package(
				[
					'source'                      => $working_dir,
					'destination'                 => WP_PLUGIN_DIR,
					'clear_destination'           => false,
					'abort_if_destination_exists' => false,
					'clear_working'               => true,
					'hook_extra'                  => [
						'type'   => 'plugin',
						'action' => 'install',
					],
				]
			);

			if ( is_wp_error( $result ) ) {
				throw new Exception( $result->get_error_message() );
			}

			$activate = true;
		} catch ( Exception $e ) {
			return $e->get_error_message();
		}

		// Discard feedback.
		ob_end_clean();
	}

	wp_clean_plugins_cache();

	// Activate this thing.
	if ( $activate ) {
		try {
			$result = activate_plugin( $installed ? $installed_plugins[ $plugin_file ] : $plugin_slug . '/' . $plugin_file );

			if ( is_wp_error( $result ) ) {
				throw new Exception( $result->get_error_message() );
			}
		} catch ( Exception $e ) {
			return $e->get_error_message();
		}
	}
}

/**
 * Get slug from path and associate it with the path.
 *
 * @param array  $plugins Associative array of plugin files to paths.
 * @param string $key Plugin relative path. Example: woocommerce/woocommerce.php.
 * @return array $plugins Associated plugins.
 */
function bigbox_associate_plugin_file( $plugins, $key ) {
	$path                 = explode( '/', $key );
	$filename             = end( $path );
	$plugins[ $filename ] = $key;

	return $plugins;
}

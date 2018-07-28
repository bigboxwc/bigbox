<?php
/**
 * WooCommerce ListTable.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category NUX
 * @author Spencer Finnell
 */

namespace BigBox\NUX;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

/**
 * WP_Plugin_Install_List_Table isn't always available. If it isn't available we load it here.
 */
if ( ! class_exists( 'WP_List_Table_Plugin_Install' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-plugin-install-list-table.php';
}

/**
 * WooCommerce ListTable.
 *
 * @since 1.0.0
 */
class WooCommerce_ListTable extends \WP_Plugin_Install_List_Table {

	/**
	 * Get all of the plugins we want to install.
	 *
	 * @since 1.0.0
	 */
	public function prepare_items() {
		$this->set_pagination_args(
			[
				'total_items' => 1,
				'per_page'    => 1,
			]
		);

		$this->items = $this->query_dotorg();
	}

	/**
	 * Query the WP.org API and get the information for each plugin.
	 *
	 * Cached with a hash of all required plugins. Updating the list will
	 * bust it and fetch them again.
	 *
	 * @since 1.0.0
	 *
	 * @return array $items
	 */
	public function query_dotorg() {
		$plugins = [ 'woocommerce' ];
		$key     = md5( serialize( $plugins ) ); // @codingStandardsIgnoreLine
		$items   = get_transient( $key );

		if ( false === $items ) {
			$items = [];

			$args = [
				'locale' => get_user_locale(),
				'fields' => [
					'last_updated'      => true,
					'icons'             => true,
					'active_installs'   => true,
					'short_description' => true,
				],
			];

			foreach ( $plugins as $plugin ) {
				$plugin = plugins_api(
					'plugin_information',
					wp_parse_args(
						[
							'slug' => $plugin,
						],
						$args
					)
				);

				if ( ! is_wp_error( $plugin ) ) {
					$items[] = $plugin;
				}
			}

			set_site_transient( $key, $items, DAY_IN_SECONDS * 30 );
		}

		return $items;
	}

	/**
	 * Output the table. Wrap in a `#plugin-filter` ID so the updates.js
	 * thinks we are on a normal plugin page.
	 *
	 * @since 1.0.0
	 */
	public function display() {
		add_thickbox();
		wp_enqueue_script( 'plugin-install' );
		wp_enqueue_script( 'updates' );

		wp_print_request_filesystem_credentials_modal();
		wp_print_admin_notice_templates();
		?>

<form id="plugin-filter" method="post">

		<?php $this->display_rows_or_placeholder(); ?>

</form>

		<?php
	}

}

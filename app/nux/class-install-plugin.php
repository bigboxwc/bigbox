<?php
/**
 * Install a plugin in a background task.
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

/**
 * Install plugin.
 *
 * @since 1.0.0
 */
class Install_Plugin extends \WP_Async_Request {

	/**
	 * @var string
	 */
	protected $action = 'install-plugin';

	/**
	 * Handle the request.
	 *
	 * @since 1.0.0
	 */
	protected function handle() {
		bigbox_install_plugin( $this->data['slug'], $this->data['plugin'] );
	}
}

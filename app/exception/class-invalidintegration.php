<?php
/**
 * Invalid integration.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Bootstrap
 * @author Spencer Finnell
 */

namespace BigBox\Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class InvalidIntegration.
 *
 * @since 1.0.0
 */
class InvalidIntegration extends \InvalidArgumentException implements BigBoxException {

	/**
	 * Create a new instance of the exception for a integration class name that is
	 * not recognized.
	 *
	 * @since 1.0.0
	 *
	 * @param string $integration Class name of the integration that was not recognized.
	 * @return static
	 */
	public static function from_integration( $integration ) {
		$message = sprintf(
			// Translators: %s integration name.
			__( 'The integration "%s" is not recognized and cannot be registered.', 'bigbox' ),
			is_object( $integration )
				? get_class( $integration )
				: (string) $integration
		);

		return new static( $message );
	}
}

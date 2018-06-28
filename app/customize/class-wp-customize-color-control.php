<?php
/**
 * Extend color picker control.
 *
 * @since 1.8.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

namespace BigBox\Customize;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add a color picker control with a defined palette.
 *
 * @since 1.0.0
 */
class WP_Customize_Color_Control extends \WP_Customize_Color_Control {

	/**
	 * Control type.
	 *
	 * @since 1.8.0
	 * @var string
	 */
	public $type = 'color-themed';

	/**
	 * Color palettes.
	 *
	 * @since 1.8.0
	 * @var array
	 */
	public $palettes = [];

	/**
	 * Register control.
	 *
	 * @since 1.8.0
	 */
	public function __construct( $manager, $id, $args = [] ) {
		parent::__construct( $manager, $id, $args );

		$palettes = [];
		$colors   = bigbox_get_theme_colors();

		foreach ( $colors as $theme_color => $color ) {
			$palettes[] = bigbox_get_theme_color( $theme_color );
		}

		$palettes = array_slice( $palettes, 0, 5 );

		$palettes[] = bigbox_get_theme_color( 'gray-400' );
		$palettes[] = bigbox_get_theme_color( 'gray-700' );

		$this->palettes = $palettes;
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 1.8.0
	 */
	public function to_json() {
		parent::to_json();

		$this->json['palettes'] = $this->palettes;
	}

}

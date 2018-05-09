<?php
/**
 * Add controls for arbitrary heading, description, line
 *
 * @since 1.0.0
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
 * Add controls for arbitrary heading, description, line
 *
 * @since 1.0.0
 */
class WP_Customize_Content_Control extends \WP_Customize_Control {

	/**
	 * Content string.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $content = '';

	/**
	 * Render the control's content.
	 *
	 * @since 1.0.0
	 */
	protected function render_content() {
		if ( isset( $this->label ) ) {
			echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
		}

		if ( isset( $this->content ) ) {
			echo $this->content; // WPCS: XSS okay.
		}

		if ( isset( $this->description ) ) {
			echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
		}
	}

}

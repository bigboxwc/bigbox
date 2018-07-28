<?php
/**
 * Append background color for FacetWP refresh.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

/**
 * Append background color for FacetWP refresh.
 */
add_action(
	'bigbox_customize_inline_css',
	/**
	 * Append background color for FacetWP refresh.
	 *
	 * @since 1.0.0
	 *
	 * @param $css BigBox\Customize\Build_Inline_CSS CSS object.
	 */
	function( $css ) {
		$css->add(
			[
				'selectors'    => [
					'.facetwp-template__loading',
				],
				'declarations' => [
					'background-color' => esc_attr( bigbox_hex_to_rgba( '#' . get_background_color(), 0.75 ) ),
				],
			]
		);
	}
);

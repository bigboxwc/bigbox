<?php
/**
 * Append store notice colors.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Theme
 * @author Spencer Finnell
 */

/**
 * Append store notice colors.
 */
add_action(
	'bigbox_customize_inline_css',

	/**
	 * Append store notice colors.
	 *
	 * @since 1.0.0
	 *
	 * @param $css BigBox\Customize\Build_Inline_CSS CSS object.
	 */
	function( $css ) {
		$text = get_theme_mod( 'demo-store-notice-color', '#565656' );
		$bg   = get_theme_mod( 'demo-store-notice-color-background', '#e8bc55' );

		$css->add(
			[
				'selectors'    => [
					'.woocommerce-store-notice',
				],
				'declarations' => [
					'color'            => esc_attr( $text ),
					'background-color' => esc_attr( $bg ),
				],
			]
		);

		$css->add(
			[
				'selectors'    => [
					'.woocommerce-store-notice a',
				],
				'declarations' => [
					'color' => esc_attr( $text ),
				],
			]
		);
	}
);

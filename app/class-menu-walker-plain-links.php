<?php
/**
 * Plain link menu walker.
 *
 * @since 1.0.0
 *
 * @package BigBox
 * @category Menu
 * @author Spencer Finnell
 */

namespace BigBox;

use Walker;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Walk a menu to just output plain anchors.
 *
 * @since 1.0.0
 */
class Menu_Walker_Plain_Links extends Walker {

	/**
	 * Link class.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $class;

	/**
	 * Class(es) to apply to anchors.
	 *
	 * @since 1.0.0
	 *
	 * @param string $class Class to apply to link item.
	 */
	public function __construct( $class = '' ) {
		$this->class = $class;
	}

	/**
	 * Walk the whole menu.
	 *
	 * @since 1.0.0
	 *
	 * @param array $items Elements to walk.
	 * @param int   $max_depth Maximum depth.
	 * @return string
	 */
	public function walk( $items, $max_depth ) {
		$list  = array();
		$items = array_map( 'wp_setup_nav_menu_item', $items );

		foreach ( $items as $item ) {
			$lists[] = sprintf( '<a href="%s">%s</a>', esc_url( $item->url ), esc_attr( $item->title ) );
		}

		return implode( '', $lists );
	}

}

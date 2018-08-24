/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Scroll a horizontal menu to the active item.
 *
 * @param {String} menuClass Menu class to select.
 * @param {String} activeClass Active menu item class to center.
 */
const horizontalMenu = ( menuClass, activeClass ) => {
  const menu = document.querySelector( menuClass );

	if ( ! menu ) {
		return;
	}

  const activeLink = document.querySelector( `${ menuClass } ${ activeClass }` );

  const activeOffset = activeLink.getBoundingClientRect();
  const menuOffset = menu.getBoundingClientRect();

  menu.scrollLeft = activeOffset.x + ( activeOffset.width / 2 ) + menu.scrollLeft - ( menuOffset.width / 2 );
};

export default horizontalMenu;

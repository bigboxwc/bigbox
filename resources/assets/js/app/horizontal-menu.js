/**
 * Extenal dependencies.
 */
import SimpleBar from 'simplebar';

/**
 * Scroll a horizontal menu to the active item.
 *
 * @param {string} menuClass Menu class to select.
 * @param {string} activeClass Active menu item class to center.
 */
const horizontalMenu = ( menuClass, activeClass ) => {
	const menu = document.querySelector( menuClass );

	if ( ! menu ) {
		return;
	}

	// Custom scrolling.
	const simpleBar = new SimpleBar( menu );
	const activeLink = document.querySelector( `${ menuClass } ${ activeClass }` );

	if ( ! activeLink ) {
		return;
	}

	const activeOffset = activeLink.getBoundingClientRect();
	const menuOffset = menu.getBoundingClientRect();

	simpleBar.getScrollElement().scrollLeft = activeOffset.x + ( activeOffset.width / 2 ) + menu.scrollLeft - ( menuOffset.width / 2 );
};

export default horizontalMenu;

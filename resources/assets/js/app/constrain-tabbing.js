/**
 * External dependencies.
 */
import { TAB } from '@wordpress/keycodes';
import { focus } from '@wordpress/dom';

/**
 * Constrain tabbing to a parent element.
 *
 * @param {Object} element HTML node.
 */
export default ( element ) => {
	/**
	 * Tab event.
	 *
	 * @param {object} event Keydown event.
	 */
	element.addEventListener( 'keydown', ( event ) => {
		if ( event.keyCode !== TAB ) {
			return;
		}

		const tabbables = focus.tabbable.find( element );

		if ( ! tabbables.length ) {
			return;
		}

		const firstTabbable = tabbables[ 0 ];
		const lastTabbable = tabbables[ tabbables.length - 1 ];

		if ( event.shiftKey && event.target === firstTabbable ) {
			event.preventDefault();
			lastTabbable.focus();
		} else if ( ! event.shiftKey && event.target === lastTabbable ) {
			event.preventDefault();
			firstTabbable.focus();
			/*
			 * When pressing Tab and none of the tabbables has focus, the keydown
			 * event happens on the wrapper div: move focus on the first tabbable.
			 */
		} else if ( ! tabbables.includes( event.target ) ) {
			event.preventDefault();
			firstTabbable.focus();
		}
	} );
};

/**
 * External dependencies.
 */
import { TAB } from '@wordpress/keycodes';

// Class to add to <body>
const bodyClass = 'is-tabbing';

/**
 * Add class to <body> when a user is tabbing.
 *
 * @param {Object} e Key event.
 */
const handleFirstTab = ( e ) => {
	const { keyCode } = e;

	if ( TAB !== keyCode ) {
		return;
	}

	document.body.classList.add( bodyClass );

	window.removeEventListener( 'keydown', handleFirstTab );
	window.addEventListener( 'mousedown', handleMouseDownOnce );
};

/**
 * Remove body class when a click event is detected.
 */
const handleMouseDownOnce = () => {
	document.body.classList.remove( bodyClass );

	window.removeEventListener( 'mousedown', handleMouseDownOnce );
	window.addEventListener( 'keydown', handleFirstTab );
};

window.addEventListener( 'keydown', handleFirstTab );

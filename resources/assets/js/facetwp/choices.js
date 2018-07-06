/* global $ */

/**
 * Internal dependencies.
 */
import { hasClass } from './../utils';

const $document = $( document );

/**
 * Add "real" checkboxes and radio.
 */
$document.on( 'facetwp-loaded', () => {
	// Add a checkbox on load.
	document.querySelectorAll( '.facetwp-checkbox, .facetwp-radio' ).forEach( ( wrapper ) => {
		// Create an input.
		const input = document.createElement( 'input' );

		input.type    = hasClass( wrapper, 'facetwp-checkbox' ) ? 'checkbox' : 'radio';
		input.checked = hasClass( wrapper, 'checked' );

		// Add to item.
		wrapper.prepend( input );

		// Better visual feedback (automatically check when clicked.)
		wrapper.addEventListener( 'click', () => {
			if ( hasClass( wrapper, 'disabled' ) ) {
				return;
			}

			input.checked = ! input.getAttribute( 'checked' );
		} );
	} );
} );

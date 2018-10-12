/* global $, _ */

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
		const hasInput = _.filter( wrapper.childNodes, ( node ) => {
			return 'INPUT' === node.tagName;
		} );

		if ( hasInput.length > 0 ) {
			return;
		}

		// Create an input.
		const input = document.createElement( 'input' );

		input.type = hasClass( wrapper, 'facetwp-checkbox' ) ? 'checkbox' : 'radio';
		input.checked = hasClass( wrapper, 'checked' );

		// Add to item.
		wrapper.prepend( input );

		// Better visual feedback (automatically check when clicked.)
		wrapper.addEventListener( 'click', () => {
			if ( hasClass( wrapper, 'disabled' ) ) {
				return;
			}

			const foundInput = wrapper.querySelector( 'input' );

			foundInput.checked = ! foundInput.checked;
		} );
	} );
} );

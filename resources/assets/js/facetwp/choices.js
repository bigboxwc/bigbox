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

		// Get wrapper unique attribute.
		const id = wrapper.dataset.value;
		console.log(id);

		// Create an input and label.
		const input = document.createElement( 'input' );
		const label = document.createElement( 'label' );

		input.type = hasClass( wrapper, 'facetwp-checkbox' ) ? 'checkbox' : 'radio';
		input.checked = hasClass( wrapper, 'checked' );
		input.id = id;

		if ( hasClass( wrapper, 'disabled' ) ) {
			input.setAttribute( 'disabled', true );
		}

		label.htmlFor = id;
		label.innerHTML = wrapper.innerText;
		label.prepend( input );

		// Add to item.
		wrapper.innerHTML = '';
		wrapper.prepend( label );

		// Better visual feedback (automatically check when clicked.)
		wrapper.addEventListener( 'click', ( e ) => {
			// Don't toggle if already disabled.
			if ( hasClass( wrapper, 'disabled' ) ) {
				return;
			}

			// Don't toggle if clicking the "[+]" or "[-]".
			if ( e.target.className === 'facetwp-expand' ) {
				return;
			}

			const foundInput = wrapper.querySelector( 'input' );

			foundInput.checked = ! foundInput.checked;
		} );
	} );
} );

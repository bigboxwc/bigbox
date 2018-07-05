/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Adjust width of navbar dropdown.
 */
export const adjustWidth = () => {
	const realSelect = document.querySelectorAll( '#search-dropdown-real select' );
	const fakeSelect = document.getElementById( 'search-dropdown-placeholder' );

	if ( ! realSelect || ! fakeSelect ) {
		return;
	}

	// Find visible option.
	const selectedText = realSelect[0].options[ realSelect[0].selectedIndex ].text;

	// Set hidden <select> to have only one value (of currently selected).
	fakeSelect.innerHTML = `<option>${ selectedText.replace( '&nbsp;', '' ) }</option>`

	// Set visible <select> to have width of hidden.
	realSelect[0].style.width = `${ fakeSelect.offsetWidth }px`;

	// Trigger again on change.
	realSelect.onchange = adjustWidth;
};

// Adjust on load.
domReady( adjustWidth );

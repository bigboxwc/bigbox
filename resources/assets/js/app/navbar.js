/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Adjust width of navbar dropdown.
 */
export const adjustWidth = () => {
	const realSelect = document.querySelector( '#search-dropdown-real select' );
	const fakeSelect = document.getElementById( 'search-dropdown-placeholder' );

	if ( ! realSelect || ! fakeSelect ) {
		return;
	}

	// Find visible option.
	const selectedText = realSelect.options[ realSelect.selectedIndex ].text;

	// Set hidden <select> to have only one value (of currently selected).
	fakeSelect.innerHTML = `<option>${ selectedText.replace( '&nbsp;', '' ) }</option>`;

	// Set visible <select> to have width of hidden.
	realSelect.style.width = `${ fakeSelect.offsetWidth }px`;

	// Trigger again on change.
	realSelect.onchange = adjustWidth;
};

domReady( () => {
	// Adjust on load.
	adjustWidth();

	/**
	 * Don't push empty form values forward.
	 */
	const searchForm = document.querySelector( '#primary-search' );

	if ( searchForm ) {
		searchForm.addEventListener( 'submit', () => {
			// All inputs.
			const inputs = searchForm.querySelectorAll( 'input, select' );

			// Inputs with a value.
			const inputsWithValues = _.filter( inputs, ( node ) => {
				if ( node.options ) {
					const selected = node.options[ node.selectedIndex ];

					return selected.value !== '' && selected.value !== selected.text && parseInt( selected.value ) !== 0;
				}

				return node.value !== '';
			} );

			// Inputs with no value.
			const noValues = _.difference( inputs, inputsWithValues );

			// Remove name from inputs with no value to avoid passing blank form values to FacetWP inital load.
			_.each( noValues, ( node ) => node.name = '' );
		} );
	}
} );

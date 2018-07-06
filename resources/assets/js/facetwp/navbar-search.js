/* global FWP, _ */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

domReady( () => {
	const liveSearch = document.getElementById( 'facetwp-primary-search' );

	if ( liveSearch ) {
		/**
		* Refresh FacetWP when on the shop page.
		*
		* @param {Event} e Submit event.
		*/
		liveSearch.addEventListener( 'submit', ( e ) => {
			e.preventDefault();

			FWP.refresh();
		} );
	}

	/**
	 * Don't push empty form values forward to help FacetWP load initially.
	 */
	const searchForm = document.querySelector( '#primary-search' );

	if ( searchForm ) {
		searchForm.addEventListener( 'submit', () => {
			// All inputs.
			const inputs = searchForm.querySelectorAll( 'input, select' );

			// Inputs with a value.
			const inputsWithValues = _.filter( inputs, node => {
				if ( node.options ) {
					const selected = node.options[ node.selectedIndex ];

					return selected.value !== '' && selected.value !== selected.text;
				}

				return node.value !== '';
			} );

			// Inputs with no value.
			const noValues = _.difference( inputs, inputsWithValues );

			// Remove name from inputs with no value to avoid passing blank form values to FacetWP inital load.
			_.each( noValues, node => node.name = '' );
		} );
	}
} );

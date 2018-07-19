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
} );

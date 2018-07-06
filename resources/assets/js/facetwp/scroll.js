/* global FWP, $ */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

domReady( () => {
	const $document = $( document );

	/**
	 * Scroll to top on refresh and show loading indicator.
	 */
	$document.on( 'facetwp-refresh', () => {
		if ( FWP.loaded ) {
			window.scrollTo( 0, 0 );

			// Add loading indicator.
			const loading = document.createElement( 'div' );
			loading.classList.add( 'facetwp-template__loading' );

			document.querySelector( '.facetwp-template' ).prepend( loading );
		}
	} );
} );

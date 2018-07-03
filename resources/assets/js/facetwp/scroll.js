/* global FWP, $ */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

domReady( () => {
	const $document = $( document );
	const $htmlbody = $( 'html, body' );

	/**
	 * Scroll to top on refresh and show loading indicator.
	 */
	$document.on( 'facetwp-refresh', () => {
		if ( FWP.loaded ) {
			$htmlbody.animate( {
				scrollTop: 0,
			}, 250 );

			$( '.facetwp-template' )
				.prepend( '<div class="facetwp-template__loading"></div>' );
		}
	} );
} );

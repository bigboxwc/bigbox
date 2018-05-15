/* global FWP, jQuery */

/**
 * Internal dependencies.
 */
import './choices.js';
import './categories.js';
import './navbar-search.js';
import './scroll.js';

import { adjustWidth } from './../app/navbar.js';

( function( $ ) {
	const $document = $( document );

	/**
	 * Adjust select widths once loaded.
	 */
	$document.on( 'facetwp-loaded', adjustWidth );
}( jQuery ) );

/* global $ */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Asset dependencies.
 */

// Styles
import '../../scss/facetwp.scss';

/**
 * Internal dependencies.
 */
import horizontalMenu from './../app/horizontal-menu.js';

import './choices.js';
import './categories.js';
import './navbar-search.js';
import './scroll.js';

import { adjustWidth } from './../app/navbar.js';
import { initLazyLoad } from './../app/lazyload.js';

domReady( () => {
	const $document = $( document );

	/**
	 * Adjust select widths once loaded.
	 */
	$document.on( 'facetwp-loaded', adjustWidth );

	/**
	 * Reinit lazy load once loaded.
	 */
	$document.on( 'facetwp-loaded', initLazyLoad );

	/**
	 * Horizontal scrolling for "Alpha" add-on.
	 */
	$document.on( 'facetwp-loaded', () => horizontalMenu( '.facetwp-type-alpha', '.selected' ) );
} );

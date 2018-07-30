/* global CustomEvent */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies.
 */
import { hasClass } from './../utils';

// Keep track of things we've found before.
const cache = {};

/**
 * Swap the source and the target content as defined by the toggle.
 *
 * @param {Object} toggle Toggle element.
 */
const targetSourceSwap = ( toggle ) => {
	const target = toggle.dataset.target;
	const source = toggle.dataset.source;

	let targetEl, sourceEl;

	if ( ! cache.source || ! cache.target ) {
		sourceEl = document.querySelector( `${ source } .offcanvas-drawer__content` );
		targetEl = document.querySelector( `${ target } .offcanvas-drawer__content` );

		cache[ source ] = sourceEl;
		cache[ target ] = targetEl;
	} else {
		sourceEl = cache.source;
		targetEl = cache.target;
	}

	targetEl.innerHTML = sourceEl.innerHTML;
	sourceEl.innerHTML = '';

	document.dispatchEvent( new CustomEvent( 'offCanvasDrawerSwap' ), {
		detail: { toggle, sourceEl, targetEl, source, target },
	} );
};

/**
 * Lock the body from scrolling when a drawer is open.
 *
 * @param {boolean} toggle Toggle on or off.
 * @return {undefined}
 */
const toggleBodyLock = ( toggle ) => document.body.classList.toggle( 'offcanvas-drawer-open', toggle );

domReady( () => {
	const toggles = document.querySelectorAll( '.offcanvas-drawer-toggle' );
	const hash = window.location.hash;

	/**
	 * Swap the source and the target content as defined by the toggle.
	 *
	 * A toggle should look like:
	 *
	 * <a data-source="#source-element" data-target="#target-element">
	 *
	 * Where each element contains a <div class="offcanvas-drawer__content" /> element that
	 * will house the content between swaps. The toggles that close the drawer should
	 * reverse the source and target elements.
	 */
	toggles.forEach( ( toggle ) => {
		toggle.addEventListener( 'click', () => {
			targetSourceSwap( toggle );
			toggleBodyLock( ! hasClass( document.body, 'offcanvas-drawer-open' ) );
		} );
	} );

	/**
	 * If there is a hash find the toggles on the page that share the hash
	 * and swap the elements on load.
	 *
	 * If the hash is prefixed with `toggle` then do not open again (closed state).
	 */
	if ( '' !== hash && ! hash.match( /toggle/i ) ) {
		const findToggle = document.querySelector( `a[href="${ hash }"]` );

		if ( findToggle ) {
			targetSourceSwap( findToggle );
			toggleBodyLock( true );
		}
	}
} );

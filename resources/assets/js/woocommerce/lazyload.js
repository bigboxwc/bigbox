/* global $ */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies.
 */
import { initLazyLoad } from './../app/lazyload.js';

/**
 * Reinit lazy load for certain triggers.
 */
domReady( () => {
  // WooCommerce uses jQuery to send out triggers.
  const $body = $( document.body );

  // Things that reload images.
	const triggers = [
		'updated_wc_div',
	];

	triggers.forEach( ( trigger ) => $body.on( trigger, initLazyLoad ) );
} );

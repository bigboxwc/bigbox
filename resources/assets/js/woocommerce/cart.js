/* global bigbox, URLSearchParams, FormData */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies.
 */
import { transformQtys, bindQtyChangeEvents } from './quantity';
import { getPartial, blockPartials, unblockPartials, updatePartialsWithResponse } from './../utils/partials.js';

// Partials to update.
const partials = {
	cart: '#bigbox-cart',
	totals: '#bigbox-cart-totals',
};

/**
 * Refresh cart when a quantity item changes.
 */
const refreshCart = () => {
	blockPartials( Object.values( partials ) );

	wp.ajax.send( 'bigbox_update_cart', {
		data: {
			_wpnonce: document.getElementById( 'woocommerce-cart-nonce' ).value,
			checkout: new URLSearchParams( new FormData( getPartial( partials.cart ) ) ).toString(),
		},
		/**
		 * Update cart partials when session has been updated.
		 *
		 * @param {Object} response AJAX response object containing cart data.
		 */
		success: ( response ) => {
			// Inject response.
			updatePartialsWithResponse( response, partials );

			// Rebind quantities.
			doQty();

			// Unblock.
			unblockPartials( Object.values( partials ) );
		},
	} );
};

/**
 * Helper to transform quantities and bind changes.
 */
const doQty = () => {
	transformQtys( partials );
	bindQtyChangeEvents( partials, refreshCart );
};

// Cart page doesn't trigger anything on load.
domReady( doQty );

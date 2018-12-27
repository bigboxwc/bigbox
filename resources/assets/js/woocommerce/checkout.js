/* global $, wp, wc_checkout_params, URLSearchParams, FormData */

/**
 * Internal dependencies.
 */
import { transformQtys, bindQtyChangeEvents } from './quantity';
import { blockPartials, unblockPartials, updatePartialsWithResponse } from './../utils/partials.js';

// WooCommerce uses jQuery to send out triggers.
const $body = $( document.body );

// Partials to update.
const partials = {
	review: '#bigbox-cart-review',
};

/**
 * Refresh partials when a quantity item changes.
 */
const refreshCheckout = () => {
	blockPartials( Object.values( partials ) );

	wp.ajax.send( 'bigbox_update_cart_review', {
		data: {
			security: wc_checkout_params.update_order_review_nonce,
			checkout: new URLSearchParams( new FormData( document.getElementById( 'bigbox-checkout' ) ) ).toString(),
		},
		/**
		 * Update cart partials when session has been updated.
		 *
		 * @param {Object} response AJAX response object containing cart data.
		 */
		success: ( response ) => {
			// Inject response.
			updatePartialsWithResponse( response, partials );

			$body.trigger( 'update_checkout' );

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
	bindQtyChangeEvents( partials, refreshCheckout );
};

/**
 * List of WooCommerce triggers that require quantities to be rebuilt.
 */
const triggers = [
	'updated_wc_div',
	'updated_checkout',
];

triggers.forEach( ( trigger ) => $body.on( trigger, doQty ) );

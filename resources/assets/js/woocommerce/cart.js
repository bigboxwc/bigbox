/* global $, _, bigbox */

/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';

// WooCommerce uses jQuery to send out triggers.
const $body = $( document.body );

// Partials to update.
export const partials = {
	cart: '#bigbox-cart',
	totals: '#bigbox-cart-totals',
	review: '#bigbox-cart-review',
};

const partialCache = {};

/**
 * Retreive a partial from the page.
 *
 * Stored in a cache because finding can happen multiple times on a page.
 *
 * @param {String} selector Partial selector.
 */
const getPartial = selector => {
	if ( partialCache.selector ) {
		return partialCache.selector;
	}

	return partialCache[ selector ] = document.querySelector( selector );
}

/**
 * Collect all quantity inputs and update to selects.
 *
 * Can't loop because we don't want to use the cache.
 */
export const transformQtys = () => {
	_.each( partials, selector => {
		document.querySelectorAll( `${ selector } .qty` ).forEach( qty => {
			transformInput( qty, false )
		} );
	} );
};

/**
 * Block partials when something is changing.
 */
export const blockPartials = () => {
	_.each( partials, selector => {
		const partial = getPartial( selector );

		if ( ! partial ) {
			return;
		}

		partial.classList.add( 'processing' );

		$( selector ).block( {
			message: null,
			overlayCSS: {
				background: bigbox.backgroundColor,
				opacity: 0.6,
			},
		} );
	} );
};

/**
 * Update partials with response data.
 *
 * @param {Object} response Response fragments to map to partials.
 */
export const updatePartials = ( response ) => {
	_.each( partials, ( selector, partialSlug ) => {
		const partial = getPartial( selector );

		if ( ! partial ) {
			return;
		}

		partial.innerHTML = response.data[ partialSlug ];
		partial.classList.remove( 'processing' );

		$( selector ).unblock();
	} );

	transformQtys();
	bindQtyChangeEvents();
};

/**
 * Refresh partials when a quantity item changes.
 */
const refreshPartialsOnChange = () => {
	blockPartials();

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
		success: response => updatePartials( response ),
	} );
}

/**
 * Update cart contents when quantity changes.
 */
const bindQtyChangeEvents = () => {
	document.querySelectorAll( `${ partials.cart } .qty` ).forEach( qty => {
		qty.addEventListener( 'change', refreshPartialsOnChange );
	} );
}

// Init.
transformQtys();
bindQtyChangeEvents();

const triggers = [
	'init_checkout',
	'payment_method_selected',
	'updated_checkout',
	'updated_wc_div',
	'updated_cart_totals',
	'updated_shipping_method',
];

triggers.forEach( trigger => $body.on( trigger, transformQtys ) );

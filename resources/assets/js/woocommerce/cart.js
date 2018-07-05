/* global $, _ */

/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';

// Partials to update.
export const partials = {
	cart: '#bigbox-cart',
	totals: '#bigbox-cart-totals',
	review: '#bigbox-cart-review',
};

const $body = $( document.body );

/**
 * Collect all quantity inputs and update to selects.
 *
 * Can't loop because we don't want to use the cache.
 */
export const transformQtys = () => {
	_.forEach( partials, ( selector ) => {
		$( selector ).find( '.qty' ).each( function() {
			transformInput( this, false );
		} );
	} );
};

/**
 * Block partials when something is changing.
 */
export const blockPartials = () => {
	_.forEach( partials, ( selector ) => {
		$( selector ).addClass( 'processing' ).block( {
			message: null,
			overlayCSS: {
				background: '#fff',
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
	_.forEach( partials, ( selector, partial ) => {
		$( selector )
			.replaceWith( response.data[ partial ] )

			// Unblock
			.removeClass( 'processing' )
			.unblock();
	} );

	transformQtys();
};

/**
 * Update cart contents when quantity changes.
 *
 * For some reason this doesn't work as well as the one in `checkout.js`
 * that targets the form directly.
 */
$body.delegate( `${ partials.cart } .qty`, 'change', () => {
	blockPartials();

	wp.ajax.send( 'bigbox_update_cart', {
		data: {
			_wpnonce: $( '#woocommerce-cart-nonce' ).val(),
			checkout: $( partials.cart ).serialize(),
		},
		/**
		 * Update cart partials when session has been updated.
		 *
		 * @param {Object} response AJAX response object containing cart data.
		 */
		success( response ) {
			updatePartials( response );
		},
	} );
} );

/**
 * Transform quantity fields.
 */
transformQtys();

const triggers = [
	'init_checkout',
	'payment_method_selected',
	'updated_checkout',
	'updated_wc_div',
	'updated_cart_totals',
	'updated_shipping_method',
];

triggers.forEach( ( trigger ) => {
	$body.on( trigger, transformQtys );
} );

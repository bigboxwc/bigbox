/**
 * External dependencies.
 */
import { forEach } from 'lodash';

/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';

// Partials to update.
export const partials = {
	'cart'  : $( '#bigbox-cart' ),
	'totals': $( '#bigbox-cart-totals' ),
	'review': $( '#bigbox-review-cart' ),
}

/**
 * Collect all quantity inputs and update to selects.
 */
export const transformQtys = function() {
	forEach ( partials, function( $el ) {
		$el.find( '.qty' ).each( function() {
			transformInput( $( this ), false );
		} );
	} );
};

/**
 * Block partials when something is changing.
 */
export const blockPartials = function() {
	forEach( partials, ( $el ) => {
		$el.addClass( 'processing' ).block( {
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		} );
	} );
}

/**
 * Update partials with response data.
 *
 * @param {object} response Response fragments to map to partials.
 */
export const updatePartials = function( response ) {
	forEach( partials, ( $el, partial ) => {
		$el
			.html( response.data[ partial ] )

			// Unblock
			.removeClass( 'processing' )
			.unblock();
	} );

	transformQtys();
}

/**
 * Update cart contents when quantity changes.
 */
partials.cart.on( 'change', '.qty', function() {
	blockPartials();

	wp.ajax.send( 'bigbox_update_cart', {
		data: {
			checkout: partials.cart.serialize(),
		},
		success( response ) {
			updatePartials( response );
		},
	} );
} );

/**
 * Transform quantity fields.
 */
transformQtys();

const $body    = $( document.body );
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

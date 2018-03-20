/**
 * External dependencies.
 */
import { forEach } from 'lodash';

/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';

// Partials to update.
const partials = {
	'cart'  : $( '#bigbox-cart' ),
	'totals': $( '#bigbox-cart-totals' ),
}

/**
 * Collect all quantity inputs and update to selects.
 */
const transformQtys = function() {
	partials.cart.find( '.qty' ).each( function() {
		transformInput( $( this ), false );
	} );
};

/**
 * Block partials when something is changing.
 */
const blockPartials = function() {
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
const updatePartials = function( response ) {
	forEach( partials, ( $el, partial ) => {
		$el
			.html( response.data[ partial ] )

			// Unblock
			.removeClass( 'processing' )
			.unblock();
	} );

	// Transform inputs to selects again.
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

// Transform quantities on load.
$( function() {
	transformQtys();
} );

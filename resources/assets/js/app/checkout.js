/* global jQuery */

/**
 * Internal dependencies.
 */
import { updatePartials, blockPartials } from './cart';

( function( $ ) {
	/**
	 * Update cart contents when quantity changes.
	 */
	$( '#bigbox-checkout' ).on( 'change', '.qty', function() {
		blockPartials();

		wp.ajax.send( 'bigbox_update_cart_review', {
			data: {
				security: wc_checkout_params.update_order_review_nonce,
				checkout: $( this ).serialize(),
			},
			success( response ) {
				updatePartials( response );
			},
		} );
	} );
} )( jQuery );

/**
 * External dependencies.
 */
import { forEach } from 'lodash';

/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';
import { partials, updatePartials, blockPartials } from './cart';

/**
 * Update cart contents when quantity changes.
 */
$( '#bigbox-checkout' ).on( 'change', '.qty', function() {
	blockPartials();

	wp.ajax.send( 'bigbox_update_cart_review', {
		data: {
			checkout: $( this ).serialize(),
		},
		success( response ) {
			updatePartials( response );
		},
	} );
} );

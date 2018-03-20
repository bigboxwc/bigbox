/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';

const $form = $( 'form.woocommerce-cart-form' );

/**
 * Collect all quantity inputs and update to selects.
 */
const transformQtys = function() {
	$form.find( '.qty' ).each( function() {
		transformInput( $( this ), false );
	} );
};

/**
 * Update cart contents when quantity changes.
 */
$form.on( 'change', '.qty', function() {
	const $input = $( this );

	$form.addClass( 'processing' ).block( {
		message: null,
		overlayCSS: {
			background: '#fff',
			opacity: 0.6
		}
	} );

	wp.ajax.send( 'bigbox_update_cart', {
		data: {
			checkout: $form.serialize(),
		},
		success( response ) {
			$form
				.html( response.data )
				.removeClass( 'processing' )
				.unblock();

			transformQtys();
		},
	} );
} );

// Update all on load.
transformQtys();

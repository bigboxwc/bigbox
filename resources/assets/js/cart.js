/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';

const $form = $( 'form.woocommerce-cart-form' );

$form.on( 'change', '.qty', function() {
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

			transformInput( $form, false );
		},
	} );
} );

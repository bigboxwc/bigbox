/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';

/**
 * Transform purchase form quantities.
 */
$(function() {

	$( 'form.cart' ).each( function() {
		const $form = $( this );
		const $qty  = $form.find( '.qty' );

		// Variation update.
		$form.on( 'show_variation', function() {
			transformInput( $qty );

			$( this ).addClass( 'woocommerce-variation--loaded' );
		} );

		// All.
		transformInput( $qty, false );
	} );

});

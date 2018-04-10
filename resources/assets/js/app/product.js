/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';

/**
 * Transform purchase form quantities.
 */
$( function() {
	// Can't cache the .qty input because it gets replaced.
	const $form = $( 'form.cart' );

	// Variation update.
	$form.on( 'show_variation', ( e, variation ) => {
		transformInput( $form.find( '.qty' ), variation );
		$form.addClass( 'woocommerce-variation--loaded' );
	} );

	// All.
	transformInput( $form.find( '.qty' ), false );
} );

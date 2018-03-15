/**
 * Transform quantity input in to a <select> box.
 *
 * @param {object} DOM element.
 * @param {bool|object} Variation
 */
const transformInput = function( $form, variation = false ) {
	const $qty      = $form.find( '.qty' )
	const $wrapper  = $form.find( '#add-to-cart-quantity' );
	const $original = $qty;

	// Remove any existing.
	$original.detach();

	const min = variation.min_qty || $original.attr( 'min' );
	let   max = variation.max_qty || $original.attr( 'max' );

	// Limit max.
	if ( '' === max ) {
		max = 30;
	}

	// Add <select>
	const $select = $( `<select class="qty" min=${min} max=${max} name=${$original.attr( 'name' )} />` );

	$wrapper.append( $select )

	// Add <option>s
	for ( i = min; i <= max; i++ ) {
		$select
			.append( $( `<option value=${i}>${i}</option>` ) );
	}
};

$(function() {

	$( 'form.cart' ).each( function() {
		const $form = $( this );

		// Variation update.
		$form.on( 'show_variation', function() {
			transformInput( $( this ) );

			$( this ).addClass( 'woocommerce-variation--loaded' );
		} );

		// All.
		transformInput( $form, false );
	} );

});
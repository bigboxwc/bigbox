/**
 * Transform quantity input in to a <select> box.
 *
 * @param {object} DOM element.
 * @param {bool|object} Variation
 */
export const transformInput = function( $qty, variation = false ) {
	const $wrapper  = $qty.parent();
	const $original = $qty;

	// Remove any existing.
	$original.detach();

	const selectedValue = variation ? 0 : $original.val();

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
	for ( let i = min; i <= max; i++ ) {
		$select
			.append( $( `<option value=${i} ${ i == selectedValue ? 'selected' : ''}>${i}</option>` ) );
	}
};

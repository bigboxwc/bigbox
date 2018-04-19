/* global bigbox */

/**
 * Create a generic list of options that can be appended multiple times.
 */
let items = [];
const globalMax = bigbox.products.quantitySelector.max;

/**
 * Generate HTML <option>s.
 *
 * Only generates new ones if a request comes in larger than the
 * previoius global max.
 *
 * @param {Int} max Number of items to generate.
 */
const getOptions = ( max = globalMax ) => {
	if ( items.length > 0 && max <= globalMax ) {
		return items;
	}

	items = [
		`<option value="0">${ bigbox.products.quantitySelector.zero }</option>`
	];

	// Pad with globalMax
	for ( let i = 1; i <= max; i++ ) {
		items.push( `<option value=${ i }>${ i }</option>` );
	}

	return items;
};

/**
 * Transform quantity input in to a <select> box.
 *
 * @param {Object} $qty DOM element.
 * @param {boolean|Object} variation Variation data.
 */
export const transformInput = function( $qty, variation = false ) {
	const $wrapper = $qty.parent();
	const $original = $qty;

	// Remove any existing.
	$original.detach();

	const id = $original.attr( 'id' );

	// Find original value.
	const selectedValue = variation ? 0 : ( $original.val() ? parseInt( $original.val() ) : 0 );

	// Try to get preset min/max values.
	const min = variation.min_qty || ( $original.attr( 'min' ) ? parseInt( $original.attr( 'min' ) ) : globalMax );
	let max = variation.max_qty || ( $original.attr( 'max' ) ? parseInt( $original.attr( 'max' ) ) : globalMax );

	// If max (or globalMax) is less than original value reset max with padding.
	if ( max < selectedValue || selectedValue === max ) {
		max = parseInt( selectedValue + globalMax );
	}

	// Add <select>
	const $select = $( `<select id=${ id } class="qty" min=${ min } max=${ max } name=${ $original.attr( 'name' ) } />` );

	$wrapper.append( $select );

	const options = getOptions( max );

	$select
		.append( options.slice( min, ( max + 1 ) ).join( '' ) )
		.find( `option[value=${ selectedValue }]` )
		.prop( 'selected', true );
};

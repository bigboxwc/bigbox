/* global bigbox, $ */

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
 * @param {number} max Number of items to generate.
 * @return {Array} List of HTML options.
 */
const getOptions = ( max = globalMax ) => {
	if ( items.length > 0 && max <= items.length ) {
		return items;
	}

	const zero = document.createElement( 'option' );
	zero.text = bigbox.products.quantitySelector.zero;
	zero.value = 0;

	// Build list.
	items = [ zero ];

	// Pad with globalMax
	for ( let i = 1; i <= max; i++ ) {
		const opt = document.createElement( 'option' );
		opt.text = opt.value = i;

		items.push( opt );
	}

	return items;
};

/**
 * Transform quantity input in to a <select> box.
 *
 * Preserve as many as the original attributes as possible.
 *
 * @param {Object} qty DOM element.
 * @param {boolean|Object} variation Variation data.
 */
export const transformInput = function( qty, variation = false ) {
	const wrapperEl = qty.parentElement;
	const original = qty;

	// Remove any existing.
	original.remove();

	const id = original.getAttribute( 'id' );

	// Find original value.
	const originalValue = original.value ? parseInt( original.value ) : 0;
	const selectedValue = variation ? 0 : ( originalValue );

	// Try to get preset min/max values.
	const min = variation.min_qty || ( original.getAttribute( 'min' ) || globalMax );
	let max = variation.max_qty || ( original.getAttribute( 'max' ) || globalMax );

	// Allow more items to be chosen if available.
	if ( ( max <= selectedValue && selectedValue !== max && max !== 1 ) || ( max === globalMax && selectedValue !== 1 ) ) {
		max = parseInt( selectedValue + globalMax );
	}

	// Add <select>
	const selectEl = document.createElement( 'select', {
		id,
		min,
		max,
		class: 'qty',
		name: original.getAttribute( 'name' ),
	} );

	const options = getOptions().slice( min, ( max + 1 ) );

	options.forEach( option => selectEl.add( option ) );

	wrapperEl.appendChild( selectEl );
};

/* global bigbox */

const { globalMax } = bigbox.woocommerce.products.quantitySelector;

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
	let items = [];

	const zero = document.createElement( 'option' );
	zero.text = bigbox.woocommerce.products.quantitySelector.zero;
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
	const selectEl = document.createElement( 'select' );

	selectEl.className = 'qty';
	selectEl.setAttribute( 'id', id );
	selectEl.setAttribute( 'min', min );
	selectEl.setAttribute( 'max', max );
	selectEl.setAttribute( 'name', original.getAttribute( 'name' ) );

	// Append options.
	const options = getOptions().slice( min, ( max + 1 ) );
	options.forEach( ( option ) => selectEl.options.add( option ) );

	// Set value now that options are present.
	selectEl.value = originalValue;

	// Show.
	wrapperEl.appendChild( selectEl );
};

/**
 * Collect all quantity <input> and update to <selects>
 *
 * @param {Array} partials List of selectors to look for inputs in.
 */
export const transformQtys = ( partials ) => {
	_.each( partials, ( selector ) => {
		document.querySelectorAll( `${ selector } .qty` ).forEach( ( qty ) => {
			transformInput( qty, false );
		} );
	} );
};

/**
 * Bind a change event to all .qty selectors in a set of partials.
 *
 * @param {Array} partials List of selectors to look for inputs in.
 * @param {Function} cb Function to call when a quantity is updated inside a partial.
 */
export const bindQtyChangeEvents = ( partials, cb ) => {
	_.each( partials, ( selector ) => {
		document.querySelectorAll( `${ selector } .qty` ).forEach( ( qty ) => {
			qty.addEventListener( 'change', cb );
		} );
	} );
};

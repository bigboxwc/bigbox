/** global bigbox */


/**
 * Create a generic list of options that can be appended multiple times.
 */
const items = [];

const getOptions = () => {
	if ( items.length > 0 ) {
		return items;
	}

	for ( let i = 0; i <= bigbox.products.quantitySelector.max; i++ ) {
		items.push( `<option value=${i}>${i}</option>` );
	}

	return items;
}

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

	const selectedValue = variation ? 0 : ( $original.val() ? parseInt( $original.val() ) : 0 );

	const min = variation.min_qty || ( $original.attr( 'min' ) ? parseInt( $original.attr( 'min' ) ) : 0 );
	let max   = variation.max_qty || ( $original.attr( 'max' ) ? parseInt( $original.attr( 'max' ) ) : 0 );

	// Limit max.
	if ( 0 === max ) {
		max = bigbox.products.quantitySelector.max;
	}

	// Add <select>
	const $select = $( `<select class="qty" min="${ min }" max="${ max }" name="${ $original.attr( 'name' ) }" />` );

	$wrapper.append( $select );

	const options = getOptions();

	$select
		.append( options.slice( min, ( max + 1 ) ).join( '' ) )
		.find( `option[value=${selectedValue}]` )
		.attr( 'selected', true );
};

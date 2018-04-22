/* global jQuery, wp, bigboxCustomizeControls, _ */

const fontList = bigboxCustomizeControls.fonts;

/**
	* Build HTML <option>s for font families.
	*
	* @return {string}
	*/
const buildFamilyOptionsHtml = () => {
	const options = [];

	options.push( '<option value="default" data-variants="100,200,300,400,500,600,700,800">System Default</option>' );

	_.each( fontList, ( data, family ) => {
		options.push( `<option value="${ family }" data-variants="${ data.variants.join( ',' ) }">${ data.label }</option>` );
	} );

	return options.join( '' );
};

/**
	* Build HTML <option>s for weight variants.
	*
	* @param  {Array} variants List of variants.
	* @return {string}
	*/
const buildWeightOptionsHtml = ( variants ) => {
	const options = [];

	_.each( variants, ( variant ) => {
		if ( ! isNaN( variant ) || 'regular' === variant ) {
			options.push( `<option value="${ variant }">${ variant }</option>` );
		}
	} );

	return options.join( '' );
};

// Wait for Customize ready.
wp.customize.bind( 'ready', ( $ ) => {
	/**
	 * Update weight fields with available options.
	 *
	 * @param {Array} variants List of variants.
	 */
	const updateWeightFields = ( variants ) => {
		_.each( [ 'base', 'bold' ], ( weight ) => {
			const control = wp.customize.control( `type-font-weight-${ weight }` );
			const value = control.setting();

			const $select = $( control.container ).find( 'select' );

			// Add HTML and select chosen item.
			$select
				.html( buildWeightOptionsHtml( variants ) )
				.val( value )
				.find( `[value="${ value }"]` )
				.attr( 'selected', true );
		} );
	};

	const familyControl = wp.customize.control( 'type-font-family' );
	const familyValue = familyControl.setting();
	const $familyInput = $( familyControl.container ).find( 'select' );

	// Update available weights when changing family.
	$familyInput.on( 'change', function() {
		const selected = $( this ).find( 'option:selected' );
		const variants = selected.data( 'variants' ) ? selected.data( 'variants' ).split( ',' ) : [ 400, 500 ];

		updateWeightFields( variants );
	} );

	// Build list of font families.
	$familyInput
		.html( buildFamilyOptionsHtml() )
		.val( familyValue )
		.find( `[value="${ familyValue }"]` )
		.attr( 'selected', true )
		.end()
		.change();
} )( jQuery );

/* global jQuery, $, wp, bigboxCustomizeControls, _ */

const fontList = bigboxCustomizeControls.fonts;

/**
 * Build HTML <option>s for font families.
 *
 * @return {string} String of HTML <option>s.
 */
const buildFamilyOptionsHtml = () => {
	const options = [];

	options.push( '<option value="default" data-variants="100,200,300,400,500,600,700,800">System Default</option>' );

	_.each( fontList, ( data ) => {
		options.push( `<option value="${ data.family }" data-category="${ data.category }" data-variants="${ data.variants.join( ',' ) }">${ data.family }</option>` );
	} );

	return options.join( '' );
};

/**
 * Build HTML <option>s for weight variants.
 *
 * @param  {Array} variants List of variants.
 * @return {string} String of HTML <option>s.
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
			.html( buildWeightOptionsHtml( variants ) );

		const $selected = $select
			.find( `[value="${ value }"]` );

		// Select if exists in list.
		if ( $selected.length > 0 ) {
			$select
				.val( value )
				.prop( 'selected', true )
				.trigger( 'change' );
			// Select first item.
		} else {
			$select
				.find( 'option:first-child' )
				.prop( 'selected', true )
				.trigger( 'change' );
		}
	} );
};

/**
 * Update category (fallback) fields with available options.
 *
 * @param {string} category Font category.
 */
const updateCategoryField = ( category ) => {
	if ( 'handwriting' === category ) {
		category = 'cursive';
	}

	wp.customize.control( 'type-font-family-fallback', ( control ) => {
		control.setting.set( category );
	} );
};

( function( $ ) {
	// Wait for Customize ready.
	wp.customize.bind( 'ready', () => {
		const familyControl = wp.customize.control( 'type-font-family' );
		const familyValue = familyControl.setting();
		const $familyInput = $( familyControl.container ).find( 'select' );

		// Update available weights when changing family.
		$familyInput.on( 'change', function() {
			const selected = $( this ).find( 'option:selected' );
			const variants = selected.data( 'variants' ) ? selected.data( 'variants' ).split( ',' ) : [ 400, 500 ];
			const category = selected.data( 'category' ) ? selected.data( 'category' ) : 'sans-serif';

			updateWeightFields( variants );
			updateCategoryField( category );
		} );

		// Build list of font families.
		$familyInput
			.html( buildFamilyOptionsHtml() )
			.val( familyValue )
			.find( `[value="${ familyValue }"]` )
			.prop( 'selected', true )
			.end()
			.change();
	} );
}( jQuery ) );

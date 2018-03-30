/** global jQuery, wp */

/**
 * External dependencies.
 */
import { forEach } from 'lodash';

// Wait for DOM ready.
(function( $ ){

	const fontList = bigboxCustomizeControls.fonts;

	/**
	 * Build HTML <option>s for font families.
	 *
	 * @return {String}
	 */
	const buildFamilyOptionsHtml = () => {
		const options = [];

		forEach( fontList, ( data, family ) => {
			options.push( `<option value="${family}" data-variants="${data.variants.join( ',' )}">${data.label}</option>` );
		} );

		return options.join( '' );
	}
	
	/**
	 * Build HTML <option>s for weight variants.
	 *
	 * @param  {Array} variants List of variants.
	 * @return {String}
	 */
	const buildWeightOptionsHtml = ( variants ) => {
		const options = [];

		forEach( variants, ( variant ) => {
			options.push( `<option value="${variant}">${variant}</option>` );
		} );

		return options.join( '' );
	}

	/**
	 * Update weight fields with available options.
	 *
	 * @param {Array} variants List of variants.
	 */
	const updateWeightFields = ( variants ) => {
		forEach( [ 'base', 'bold', ], ( weight ) => {
			const control = wp.customize.control( `type-font-weight-${weight}` );
			const value   = control.setting();

			// Add HTML and select chosen item.
			$( control.container ).find( 'select' )
				.html( buildWeightOptionsHtml( variants ) )
				.val( value )
				.find( `[value="${value}"]` )
				.attr( 'selected', true )
		} );
	}

	// Wait for Customize ready.
	wp.customize.bind( 'ready', () => {
		const familyControl = wp.customize.control( 'type-font-family' );
		const familyValue   = familyControl.setting();
		const $familyInput  = $( familyControl.container ).find( 'select' );

		// Update available weights when changing family.
		$familyInput.on( 'change', function( e ) {
			const selected = $(this).find( 'option:selected' );
			const variants = selected.data( 'variants' ) ? selected.data( 'variants' ).split( ',' ) : [ 400, 500 ];

			updateWeightFields( variants );
		} );

		// Build list of font families.
		$familyInput
			.append( buildFamilyOptionsHtml() )
			.val( familyValue )
			.find( `[value="${familyValue}"]` )
			.attr( 'selected', true )
			.end()
			.change();
	} );
})( jQuery );

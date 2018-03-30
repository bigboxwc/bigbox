/** global jQuery, wp */

/**
 * External dependencies.
 */
import { forEach } from 'lodash';

// Wait for DOM ready.
(function( $ ){

	const fontList = bigboxCustomizeControls.fonts;

	const buildOptions = () => {
		const options = [];

		forEach( fontList, ( data, family ) => {
			options.push( `<option value="${family}" data-variants="${data.variants.join( ',' )}">${data.label}</option>` );
		} );

		return options;
	}

	// Wait for Customize ready.
	wp.customize.bind( 'ready', () => {

		const familyControl = wp.customize.control( 'type-font-family' );
		const $familyInput  = $( familyControl.container ).find( 'select' );

		$familyInput
			.append( buildOptions() )
			.on( 'change', function( e ) {
				console.log( 'wat' );

			} );
	} );
})( jQuery );

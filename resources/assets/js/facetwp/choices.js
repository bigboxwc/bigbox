/* global jQuery */

( function( $ ) {
	const $document = $( document );

	/**
	 * Add "real" checkboxes and radio.
	 */
	$document.on( 'facetwp-loaded', () => {
		$( '.facetwp-checkbox, .facetwp-radio' ).each( function() {
			const $wrapper = $( this );
			const $input = $( this ).find( 'input' );
			const type = $wrapper.hasClass( 'facetwp-checkbox' ) ? 'checkbox' : 'radio';

			if ( $input.length ) {
				return;
			}

			$wrapper
				.prepend( `<input type="${ type }" ${ $wrapper.hasClass( 'checked' ) ? 'checked' : '' } />` );

			$wrapper.on( 'click', function() {
				const $dynamicInput = $wrapper.find( 'input' );

				if ( $wrapper.hasClass( 'disabled' ) ) {
					return;
				}

				$dynamicInput.prop( 'checked', ! $dynamicInput.prop( 'checked' ) );
			} );
		} );
	} );
}( jQuery ) );

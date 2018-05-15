/* global FWP, jQuery */

( function( $ ) {
	/**
	 * Refresh FacetWP when on the shop page.
	 *
	 * @param {Event} e Submit event.
	 */
	$( '#facetwp-primary-search' ).submit( function( e ) {
		e.preventDefault();

		FWP.refresh();
	} );

	/**
	 * Don't push empty form values forward to help FacetWP load initially.
	 */
	const searchForm = document.querySelector( '#primary-search' );

	if ( searchForm ) {
		searchForm.addEventListener( 'submit', function() {
			// All inputs.
			const inputs = searchForm.querySelectorAll( 'input, select' );

			// Inputs with a value.
			const inputsWithValues = _.filter( inputs, function( node ) {
				if ( node.options ) {
					const selected = node.options[ node.selectedIndex ];

					return selected.value !== '' && selected.value !== selected.text;
				}

				return node.value !== '';
			} );

			// Inputs with no value.
			const noValues = _.difference( inputs, inputsWithValues );

			// Remove name from inputs with no value to avoid passing blank form values to FacetWP inital load.
			_.each( noValues, function( node ) {
				node.name = '';
			} );
		} );
	}
}( jQuery ) );

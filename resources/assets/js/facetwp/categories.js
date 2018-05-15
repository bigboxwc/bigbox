/* global FWP, jQuery */

( function( $ ) {
	const $document = $( document );

	/**
	 * Hide categories if filtering with facets.
	 */
	const categories = document.querySelector( '.products-categories' );

	if ( categories ) {
		$document.on( 'facetwp-loaded', () => {
			if ( FWP.loaded ) {
				categories.style.display = 'none';
			}

			if ( '' !== FWP.build_query_string() ) {
				categories.style.display = 'none';
			}
		} );
	}
}( jQuery ) );

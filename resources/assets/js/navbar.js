/** global $ */

const $real = $( '#search-dropdown-real' ).find( 'select' );
const $fake = $( '#search-dropdown-placeholder' )

/**
 * Adjust width of navbar dropdown.
 */
export const adjustWidth = () => {
	let selected = $real.find( 'option:selected' ).text();

	if ( selected.length ) {
		$fake.find( 'option' ).html( selected );
	}

	$real.width( $fake.width() );
};

$( () => {

	// Adjust on change.
	$real.change( adjustWidth );

	// Adjust on load.
	adjustWidth();

} );

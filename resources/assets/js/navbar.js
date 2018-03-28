/** global $ */

$( () => {

	$real = $( '#navbar-search__category select:first-of-type' );
	$fake = $( '#navbar-search__category select:last-of-type' )

	$real.change( () => {
		$fake.find( 'option' ).html( $real.find( 'option:selected' ).text() );
		$real.width( $fake.width() );
	} );

} );

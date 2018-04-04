/** global $ */

$( () => {

	$real = $( '#navbar-search__category select:first-of-type' );
	$fake = $( '#navbar-search__category select:last-of-type' )

	const adjustWidth = () => {
		$fake.find( 'option' ).html( $real.find( 'option:selected' ).text() );
		$real.width( $fake.width() );
	};

	$real.change( () => {
		adjustWidth();
	} );

	adjustWidth();

} );

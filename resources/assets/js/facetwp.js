/** global wp */

// Don't push empty form values forward to help FacetWP load initially.
$( '#primary-search' ).submit( function () {
	$( this )
		.find( 'input[name], select' )
		.filter( function () {
			return ! this.value;
		} )
		.prop( 'name', '' );
});

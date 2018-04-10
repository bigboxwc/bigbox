/** global $ */

$( () => {

	// Create a separate clickable area on menu items with children.
	$( '#navbar-mobile' ).find( '.menu-item-has-children' ).each( function() {
		$( this ).append( '<span class="mobile-menu-children-toggle"></span>' );
	} );

	// Toggle children.
	$( '#navbar-mobile' ).find( '.mobile-menu-children-toggle' ).on( 'click', function() {
		$( this ).parent().toggleClass( 'menu-item--opened' );
	} );
} );

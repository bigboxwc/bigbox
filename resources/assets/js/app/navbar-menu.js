/** global $ */

$( () => {

	const $mobile  = $( '#navbar-mobile' );
	const $primary = $( '#navbar-primary' );

	// Create a separate clickable area on menu items with children.
	$mobile.find( '.menu-item-has-children' ).each( function() {
		$( this ).append( '<span class="mobile-menu-children-toggle"></span>' );
	} );

	// Toggle children.
	$mobile.find( '.mobile-menu-children-toggle' ).on( 'click', function() {
		$( this ).parent().toggleClass( 'menu-item--opened' );
	} );

	const toggleClasses = function( $el ) {
		$el
			.toggleClass( 'menu-item-has-children--active' )
			.parent()
			.toggleClass( 'sub-menu--has-sibling' );
	}

	$( '.menu-item-has-children' ).hoverIntent({
		over: function() {
			toggleClasses( $( this ) );
		},
		out: function() {
			toggleClasses( $( this ) );
		},
		timeout: 200,
		sensitivity: 7,
		interval: 90
	});
} );

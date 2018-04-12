/* global jQuery */

const $mobile = $( '#navbar-mobile' );

/**
 * Create a separate clickable area on menu items with children on mobile.
 */
export const addChildToggles = () => {
	$mobile.find( '.menu-item-has-children' ).each( function() {
		$( this ).append( '<span class="mobile-menu-children-toggle"></span>' );
	} );
};

/**
 * Better hover behavior.
 */
const addHoverIntent = () => {
	const toggleClasses = function( $el ) {
		$el
			.toggleClass( 'menu-item-has-children--active' )
			.parent()
			.toggleClass( 'sub-menu--has-sibling' );
	};

	$( '.menu-item-has-children' ).hoverIntent( {
		over: function() {
			toggleClasses( $( this ) );
		},
		out: function() {
			toggleClasses( $( this ) );
		},
		timeout: 200,
		sensitivity: 7,
		interval: 90,
	} );
}

( function( $ ) {
	addChildToggles();
	addHoverIntent();

	// Toggle children.
	$mobile.on( 'click', '.mobile-menu-children-toggle', function() {
		$( this ).parent().toggleClass( 'menu-item--opened' );
	} );

	// Add child toggles if needed.
	$( document.body ).on( 'offCanvasDrawerSwap', addChildToggles );

} )( jQuery );

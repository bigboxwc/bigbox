/* global jQuery, wp, bigboxCustomizeControls, _ */

/**
 * External dependencies.
 */
import 'bootstrap/js/src/popover';

const pointerDefaults = {
	container: '#customize-controls',
	placement: 'left',
	template: bigboxCustomizeControls.walkthrough.template,
};

const addPointer = ( pointer ) => {
	const $el = $( pointer.el );

	$el.popover( {
		...pointer,
		...pointerDefaults,
	} );

	$el.popover( 'show' );
};

const startPointers = () => {
	_.forEach( bigboxCustomizeControls.walkthrough.pointers, ( pointer ) => addPointer( pointer ) );
};

( function( $ ) {
	if ( ! bigboxCustomizeControls.walkthrough.active ) {
		return;
	}

	// Wait for Customize ready.
	wp.customize.bind( 'ready', startPointers );
}( jQuery ) );

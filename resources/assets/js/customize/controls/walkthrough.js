/* global jQuery, wp, bigboxCustomizeControls, _ */

/**
 * External dependencies.
 */
import 'bootstrap/js/src/popover';

let activePointer = 0;

const {
	active,
	template,
	pointers,
} = bigboxCustomizeControls.walkthrough;

const pointerDefaults = {
	container: '#customize-controls',
	placement: 'right',
	template: template,
};

const prevPointer = () => {
	return activePointer - 1 >= 0 ? activePointer - 1 : 0;
}

const nextPointer = () => {
	return activePointer + 1 <= pointers.length ? activePointer + 1 : pointers.length;
}

const hideActivePointer = () => {
	$( pointers[ activePointer ].el ).popover( 'hide' );
}

const showPointer = ( pointer ) => {
	// Hide previous pointer.
	hideActivePointer();

	// Set current pointer.
	activePointer = pointer;

	// Display.
	const pointerObj = pointers[ pointer ];
	const $el = $( pointerObj.el );

	$el.popover( {
		...pointerObj,
		...pointerDefaults,
	} );
	console.log( {
		...pointerObj,
		...pointerDefaults,
	} );

	// Attempt to focus a portion of the UI then show popover.
	if ( pointerObj.focus ) {
		const ui = wp.customize[ pointerObj.focusType ]( pointerObj.focus );

		ui.focus();
		ui.container.on( 'expanded', function() {
			$el.popover( 'show' );
		} );
	} else {
		$el.popover( 'show' );
	}
};

( function( $ ) {
	if ( ! active ) {
		return;
	}

	const $customizer = $( '.wp-customizer' );

	// Wait for Customize ready.
	wp.customize.bind( 'ready', () => showPointer( 0 ) );

	// Go forward.
	$customizer.on( 'click', '.popover .next', () => showPointer( nextPointer() ) );

	// Dismiss
	$customizer.on( 'click', '.popover .close', hideActivePointer );
}( jQuery ) );

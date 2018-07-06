/* global $ */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies.
 */
import { hasClass, isHidden } from './../utils';

/**
 * Better hover behavior.
 */
const addHoverIntent = () => {
	/**
	 * Toggle menu classes when a hoverIntent has been toggled.
	 *
	 * @param {Object} el Element that was hovered.
	 */
	const toggleClasses = function( el ) {
		el.classList.toggle( 'menu-item-has-children--active' );
		el.parentElement.classList.toggle( 'sub-menu--has-sibling' );
	};

	$( '#navbar-primary .menu-item-has-children' ).hoverIntent( {
		/**
		 * When the mouse is over the element.
		 */
		over: function() {
			toggleClasses( this );
		},
		/**
		 * When the mouse leaves the element.
		 */
		out: function() {
			toggleClasses( this );
		},
		timeout: 200,
		sensitivity: 7,
		interval: 90,
	} );
};

/**
 * Touch support for tablets.
 */
const addTabletSupport = () => {
	const navigationSelector = '#navbar-primary .navbar-menu__items';
	const navigation = document.querySelector( navigationSelector );

	if ( ! navigation ) {
		return;
	}

	const toggles = document.querySelectorAll( `${ navigationSelector } .menu-item-has-children > a` );

	/**
	 * Handle a touch event.
	 *
	 * Adds a focus class to current element.
	 *
	 * @param {Object} e Touch event.
	 */
	const handleTouch = function( e ) {
		const el = this.parentElement;

		if ( ! hasClass( el, 'focus' ) ) {
			e.preventDefault();

			// Remove all other focused items.
			toggles.forEach( ( toggle ) => toggle.parentElement.classList.remove( 'focus' ) );

			// Focus item.
			el.classList.toggle( 'focus' );
		}
	}

	/**
	 * Apply touch events to menu items.
	 */
	const toggleFocusTouchScreen = () => {
		// Close when document is clicked close all menus.
		document.addEventListener( 'touchstart', ( e ) => {
			if ( ! e.target.closest( '.navbar-menu__items li' ) ) {
				document.querySelectorAll( '.navbar-menu__items li' ).forEach( ( el ) => el.classList.remove( 'focus' ) );
			}
		} );

		// When the mobile menu toggle is not visible apply touch events to menu links.
		if ( isHidden( document.querySelector( '.navbar-mobile-toggle--open' ) ) ) {
			toggles.forEach( ( toggle ) => toggle.addEventListener( 'touchstart', handleTouch ) );
		} else {
			toggles.forEach( ( toggle ) => toggle.removeEventListener( 'touchstart', handleTouch ) );
		}
	}

	// Add touch events.
	if ( 'ontouchstart' in window ) {
		window.onresize = toggleFocusTouchScreen;
		toggleFocusTouchScreen();
	}
};

/**
 * Mobile panels.
 */
const addMobilePanels = () => {
	document.querySelectorAll( '#navbar-mobile .menu-item-has-children' ).forEach( ( el ) => {
		el.addEventListener( 'click', function( e ) {
			e.stopPropagation();
			el.classList.toggle( 'menu-item-has-children--active' );
		} );
	} );
};

// Init
domReady( () => {
	addHoverIntent();
	addTabletSupport();
	addMobilePanels();
} );

// Add Mobile Panels again when drawers swap.
document.addEventListener( 'offCanvasDrawerSwap', addMobilePanels );

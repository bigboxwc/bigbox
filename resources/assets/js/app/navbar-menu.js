/* global $ */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies.
 */
import { hasClass, isHidden, findAncestor } from './../utils';

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
	const navigations = document.querySelectorAll( navigationSelector );

	if ( ! navigations ) {
		return;
	}

	const toggles = [];

	navigations.forEach( ( navigation ) => {
		navigation.querySelectorAll( '.menu-item-has-children > a' ).forEach( ( el ) => toggles.push( el ) );
	} );

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
	};

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
	};

	// Add touch events.
	if ( 'ontouchstart' in window ) {
		window.onresize = toggleFocusTouchScreen;
		toggleFocusTouchScreen();
	}
};

/**
 * Mobile support.
 *
 * When in mobile parent menu items are only used to toggle their children.
 */
const addMobileSupport = () => {
	// Find all the toggles in multiple navigations.
	const navigationSelector = '#navbar-mobile .navbar-menu__items';
	const navigations = document.querySelectorAll( navigationSelector );

	if ( ! navigations ) {
		return;
	}

	const toggles = [];

	navigations.forEach( ( navigation ) => {
		navigation.querySelectorAll( '.menu-item-has-children > a, .menu-item-is-back > a' ).forEach( ( el ) => toggles.push( el ) );
	} );

	toggles.forEach( ( toggle ) => toggle.addEventListener( 'click', ( e ) => {
		e.preventDefault();

		// Remove active when a toggle is clicked.
		findAncestor( e.target, 'menu-item-has-children' ).classList.toggle( 'menu-item-has-children--active' );
	} ) );
};

// Init
domReady( () => {
	addHoverIntent();
	addTabletSupport();
} );

document.addEventListener( 'offCanvasDrawerSwap', addMobileSupport );

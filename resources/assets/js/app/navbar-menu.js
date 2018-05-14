/* global jQuery */

( function( $ ) {
	const $mobile = $( '#navbar-mobile' );

	/**
	 * Create a separate clickable area on menu items with children on mobile.
	 */
	const addChildToggles = () => {
		$mobile.find( '.menu-item-has-children' ).each( function() {
			$( this ).append( '<span class="mobile-menu-children-toggle"></span>' );
		} );
	};

	/**
	 * Better hover behavior.
	 */
	const addHoverIntent = () => {
		/**
		 * Toggle menu classes when a hoverIntent has been toggled.
		 *
		 * @param {Object} $el Element that was hovered.
		 */
		const toggleClasses = function( $el ) {
			$el
				.toggleClass( 'menu-item-has-children--active' )
				.parent()
				.toggleClass( 'sub-menu--has-sibling' );
		};

		$( '.menu-item-has-children' ).hoverIntent( {
			/**
			 * When the mouse is over the element.
			 */
			over: function() {
				toggleClasses( $( this ) );
			},
			/**
			 * When the mouse leaves the element.
			 */
			out: function() {
				toggleClasses( $( this ) );
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
		const $navigation = $( '#navbar-primary' ).find( '.navbar-menu__items' );

		if ( ! $navigation.length ) {
			return;
		}

		/**
		 * Apply touch events to menu items.
		 */
		function toggleFocusTouchScreen() {
			const $toggles = $navigation.find( '.menu-item-has-children > a' );

			// Close when document is clicked close all menus.
			$( document.body ).on( 'touchstart', ( e ) => {
				if ( ! $( e.target ).closest( '.navbar-menu__items li' ).length ) {
					$( '.navbar-menu__items li' ).removeClass( 'focus' );
				}
			} );

			// When the mobile menu toggle is not visible apply touch events to menu links.
			if ( 'none' === $( '.navbar-mobile-toggle--open' ).css( 'display' ) ) {
				$toggles.on( 'touchstart', function( e ) {
					const $el = $( this ).parent( 'li' );

					if ( ! $el.hasClass( 'focus' ) ) {
						e.preventDefault();

						$el.toggleClass( 'focus' );
						$el.siblings( '.focus' ).removeClass( 'focus' );
					}
				} );
			} else {
				$toggles.unbind( 'touchstart' );
			}
		}

		if ( 'ontouchstart' in window ) {
			$( window ).on( 'resize', toggleFocusTouchScreen );
			toggleFocusTouchScreen();
		}
	};

	addChildToggles();
	addHoverIntent();
	addTabletSupport();

	// Toggle children.
	$mobile.on( 'click', '.mobile-menu-children-toggle', function() {
		$( this ).parent( '.menu-item-has-children' ).toggleClass( 'menu-item--opened' );
	} );

	// Add child toggles if needed.
	$( document.body ).on( 'offCanvasDrawerSwap', addChildToggles );
}( jQuery ) );

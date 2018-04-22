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
	};

	/**
	 * Touch support for tablets.
	 */
	const addTabletSupport = () => {
		const $navigation = $( '#navbar-primary' ).find( '.navbar-menu__items' );

		if ( ! $navigation.length ) {
			return;
		}

		function toggleFocusTouchScreen() {
			const $toggles = $navigation.find( '.menu-item-has-children > a' );

			// Close when document is clicked.
			$( document.body ).on( 'touchstart', ( e ) => {
				if ( ! $( e.target ).closest( '.navbar-menu__items li' ).length ) {
					$( '.navbar-menu__items li' ).removeClass( 'focus' );
				}
			} );

			// Toggle check touched.
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
		$( this ).parent().toggleClass( 'menu-item--opened' );
	} );

	// Add child toggles if needed.
	$( document.body ).on( 'offCanvasDrawerSwap', addChildToggles );
}( jQuery ) );

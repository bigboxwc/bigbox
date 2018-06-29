/* global $ */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

domReady( function() {
	const $body = $( 'body' );
	const $window = $( window );

	/**
	 * If we are on a demo store and top position adjust the body offset.
	 */
	if ( $body.hasClass( 'woocommerce-demo-store' ) ) {
		// Don't want to set full bundle as dependency so wait until WooCommerce adjusts.
		setTimeout( () => {
			const $notice = $( '.woocommerce-store-notice--top:visible' );

			if ( 0 === $notice.length ) {
				return;
			}

			const resizeOffset = () => {
				$body.css( 'padding-top', $notice.outerHeight() );
			};

			// Toggle adjustments.
			resizeOffset();
			$window.on( 'resize', resizeOffset );
			$( '.woocommerce-store-notice__dismiss-link' ).on( 'click', resizeOffset );
		}, 200 );
	}
} );

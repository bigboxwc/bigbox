/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies.
 */
import { hasClass } from './../utils';

domReady( () => {
	if ( ! hasClass( document.body, 'woocommerce-demo-store' ) ) {
		return;
	}

	const notice = document.querySelector( '.woocommerce-store-notice--top' );

	if ( ! notice ) {
		return;
	}

	/**
	 * If we are on a demo store and top position adjust the body offset.
	 *
	 * @return {undefined}
	 */
	const resizeOffset = () => document.body.style.paddingTop = `${ notice.offsetHeight }px`;

	// Toggle adjustments.
	resizeOffset();

	window.addEventListener( 'resize', resizeOffset );

	document.querySelector( '.woocommerce-store-notice__dismiss-link' ).addEventListener( 'click', resizeOffset );
} );

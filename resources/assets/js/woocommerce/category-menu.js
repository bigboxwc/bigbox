/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies.
 */
import horizontalMenu from './../app/horizontal-menu.js';

domReady( horizontalMenu( '.site-primary > .woocommerce-product-categories-wrapper' ) );

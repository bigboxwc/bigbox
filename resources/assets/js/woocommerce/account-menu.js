/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies.
 */
import horizontalMenu from './../app/horizontal-menu.js';

domReady( horizontalMenu( '.woocommerce-MyAccount-navigation ul', '.is-active' ) );

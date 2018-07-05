/* global $, wc_single_product_params */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';

/**
 * Transform purchase form quantities.
 */
domReady( () => {
	// Can't cache the .qty input because it gets replaced.
	const $form = $( 'form.cart' );

	// Variation update.
	$form.on( 'show_variation', ( e, variation ) => {
		transformInput( document.querySelector( 'form.count .qty' ), variation );
		$form.addClass( 'woocommerce-variation--loaded' );
	} );

	// All.
	$form.find( '.qty' ).each( function() {
		transformInput( this, false );
	} );
} );

/**
 * Submit product category selector.
 */
domReady( () => {
	const $form = $( '#product-category-selector' );

	// Variation update.
	$form.find( 'select' ).on( 'change', () => {
		$form.submit();
	} );
} );

/**
 * Set width of flexSlider.
 */
domReady( () => {
	if ( typeof wc_single_product_params === 'undefined' ) { // eslint-disable-line camelcase
		return;
	}

	const params = wc_single_product_params || {}; // eslint-disable-line camelcase

	if ( ! params.flexslider ) {
		return;
	}

	$( '.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image:eq(0) .wp-post-image' ).on( 'load', () => {
		$( '.woocommerce-product-gallery--with-images .flex-viewport' ).css( 'maxWidth', `${ params.flexslider.itemWidth }px` );
	} );
} );

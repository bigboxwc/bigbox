/* global $, wc_single_product_params */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Internal dependencies.
 */
import { transformQtys, transformInput } from './quantity';

/**
 * Transform purchase form quantities.
 */
domReady( () => {
	const form = document.querySelector( '.woocommerce-purchase-form form.cart' );

	// Variation update. Have to use jQuery because WooCommerce does.
	$( form ).on( 'show_variation', ( e, variation ) => {
		transformInput( document.querySelector( 'form.cart .qty' ), variation );
		form.classList.add( 'woocommerce-variation--loaded' );
	} );

	transformQtys( [ '.woocommerce-purchase-form form.cart' ] );
} );

/**
 * Submit product category selector.
 */
domReady( () => {
	const form = document.getElementById( 'product-category-selector' );
	const select = document.querySelector( '#product-category-selector select' );

	if ( ! select || ! form ) {
		return;
	}

	select.addEventListener( 'change', () => form.submit() );
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

	const { itemWidth, thumbnailPosition } = params.flexslider;

	const img = document.querySelector( '.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image .wp-post-image' );
	const flex = document.querySelector( '.woocommerce-product-gallery--with-images .flex-viewport' );

	if ( ! img || ! flex ) {
		return;
	}

	img.addEventListener( 'load', () => {
		// Max width of wrapper.
		flex.style.maxWidth = `${ itemWidth }px`;

		// Contain whole gallery when thumbnails are on the bottom.
		if ( 'bottom' === thumbnailPosition ) {
			const wrapper = document.querySelector( '.woocommerce-product-gallery--with-images' );
			const nav = document.querySelector( '.woocommerce-product-gallery--with-images .flex-control-nav' );

			nav.style.maxWidth = `${ itemWidth }px`;
			wrapper.style.maxWidth = `${ itemWidth }px`;
		}
	} );
} );

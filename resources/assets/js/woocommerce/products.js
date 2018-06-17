/* global jQuery, wc_single_product_params */

/**
 * Internal dependencies.
 */
import { transformInput } from './quantity';

/**
 * Transform purchase form quantities.
 */
( function( $ ) {
	// Can't cache the .qty input because it gets replaced.
	const $form = $( 'form.cart' );

	// Variation update.
	$form.on( 'show_variation', ( e, variation ) => {
		transformInput( $form.find( '.qty' ), variation );
		$form.addClass( 'woocommerce-variation--loaded' );
	} );

	// All.
	$form.find( '.qty' ).each( function() {
		transformInput( $( this ), false );
	} );
}( jQuery ) );

/**
 * Submit product category selector.
 */
( function( $ ) {
	const $form = $( '#product-category-selector' );

	// Variation update.
	$form.find( 'select' ).on( 'change', () => {
		$form.submit();
	} );
}( jQuery ) );

/**
 * Set width of flexSlider.
 */
( function( $ ) {
	if ( typeof wc_single_product_params === 'undefined' ) {
		return;
	}

	const params = wc_single_product_params || {};

	if ( ! params.flexslider ) {
		return;
	}

	$( '.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image:eq(0) .wp-post-image' ).on( 'load', () => {
		$( '.woocommerce-product-gallery--with-images .flex-viewport' ).css( 'maxWidth', `${ params.flexslider.itemWidth }px` );
	} );
}( jQuery ) );

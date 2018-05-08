/* global FWP, jQuery */

/**
 * Internal dependencies.
 */
import { adjustWidth } from './navbar.js';

( function( $ ) {
	const $document = $( document );
	const $htmlbody = $( 'html, body' );

	/**
	 * Refresh FacetWP when on the shop page.
	 *
	 * @param {Event} e Submit event.
	 */
	$( '#facetwp-primary-search' ).submit( function( e ) {
		e.preventDefault();

		FWP.refresh();
	} );

	/**
	 * Don't push empty form values forward to help FacetWP load initially.
	 */
	const searchForm = document.querySelector( '#primary-search' );

	if ( searchForm ) {
		searchForm.addEventListener( 'submit', function() {
			// All inputs.
			const inputs = searchForm.querySelectorAll( 'input, select' );

			// Inputs with a value.
			const inputsWithValues = _.filter( inputs, function( node ) {
				if ( node.options ) {
					const selected = node.options[ node.selectedIndex ];

					return selected.value !== '' && selected.value !== selected.text;
				}

				return node.value !== '';
			} );

			// Inputs with no value.
			const noValues = _.difference( inputs, inputsWithValues );

			// Remove name from inputs with no value to avoid passing blank form values to FacetWP inital load.
			_.each( noValues, function( node ) {
				node.name = '';
			} );
		} );
	}

	/**
	 * Adjust select widths once loaded.
	 */
	$document.on( 'facetwp-loaded', adjustWidth );

	/**
	 * Hide categories if filtering with facets.
	 */
	const categories = document.querySelector( '.products-categories' );

	$document.on( 'facetwp-loaded', () => {
		if ( FWP.loaded ) {
			$htmlbody.animate( {
				scrollTop: $( '#main' ).offset().top,
			}, 250 );

			categories.style.display = 'none';
		}

		if ( '' !== FWP.build_query_string() ) {
			categories.style.display = 'none';
		}
	} );

	/**
	 * Add "real" checkboxes and radio.
	 */
	$document.on( 'facetwp-loaded', () => {
		$( '.facetwp-checkbox, .facetwp-radio' ).each( function() {
			const $wrapper = $( this );
			const type = $wrapper.hasClass( 'facetwp-checkbox' ) ? 'checkbox' : 'radio';

			$wrapper
				.prepend( `<input type="${ type }" ${ $wrapper.hasClass( 'checked' ) ? 'checked' : '' } />` );

			$wrapper.on( 'click', function() {
				const $input = $( this ).find( 'input' );

				$input.attr( 'checked', ! $input.attr( 'checked' ) );
			} );
		} );
	} );
}( jQuery ) );

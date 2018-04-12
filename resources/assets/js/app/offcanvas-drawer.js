/* global jQuery */

// Keep track of things we've found before.
const cache = {};

// Document
const $document = $( document.body );

/**
 * Swap the source and the target content as defined by the toggle.
 *
 * @param {Object} $toggle Toggle element.
 */
const targetSourceSwap = ( $toggle ) => {
	const target = $toggle.data( 'target' );
	const source = $toggle.data( 'source' );

	let $source = $target = null;

	if ( ! cache.source || ! cache.target ) {
		$source = $( source ).find( '.offcanvas-drawer__content' );
		$target = $( target ).find( '.offcanvas-drawer__content' );

		cache[source] = $source;
		cache[target] = $target;
	} else {
		$source = cache.source;
		$target = cache.target;
	}

	const toTransfer = $source.html();

	$target.html( toTransfer );
	$source.html( '' );

	$document.trigger( 'offCanvasDrawerSwap', [ $toggle, $source, $target, source, target ] );
};

( function( $ ) {

	const $toggle = $( '.offcanvas-drawer-toggle' );
	const hash    = window.location.hash;

	/**
	 * Swap the source and the target content as defined by the toggle.
	 *
	 * A toggle should look like:
	 *
	 * <a data-source="#source-element" data-target="#target-element">
	 *
	 * Where each element contains a <div class="offcanvas-drawer__content" /> element that
	 * will house the content between swaps. The toggles that close the drawer should
	 * reverse the source and target elements.
	 */
	$toggle.on( 'click', function( e ) {
		targetSourceSwap( $( this ) );
	} );

	/**
	 * If there is a hash find the toggles on the page that share the hash
	 * and swap the elements on load.
	 */
	if ( '' !== hash && ! hash.match( /toggle/i ) ) {
		$toggle.each( function() {
			const $maybeToggle = $( this );

			if ( $maybeToggle.attr( 'href' ) === hash ) {
				targetSourceSwap( $maybeToggle );
			}
		} );
	}

} )( jQuery );

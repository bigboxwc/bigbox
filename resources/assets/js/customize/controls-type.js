/** global jQuery, wp */

/**
 * External dependencies.
 */
import { filter, forEach, debounce } from 'lodash';

// Wait for DOM ready.
(function( $ ){

	// Wait for Preview ready.
	wp.customize.bind( 'preview-ready', () => {

	} );

})( jQuery );

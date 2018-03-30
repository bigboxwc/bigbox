/**
 * Internal dependencies.
 */
import './customize/preview-colors.js';

export const updateCss = () => {
	wp.ajax.send( 'bigbox-preview-css', {
		success: ( response ) => {

			// Update inline CSS.
			const selector = 'bigbox-inline-css';

			$( `#${selector}` ).remove();

			$( '<div>', {
				id:   selector,
				html: '&shy;<style>' + response + '</style>'
			} ).appendTo( 'body' );
		},
	} );
};

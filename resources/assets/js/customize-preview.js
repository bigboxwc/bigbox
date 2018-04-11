/* global WebFont, jQuery */

/**
 * External dependencies.
 */
import { filter, forEach, debounce } from 'lodash';

/**
 * Update inline CSS and webfonts.
 */
const updateCss = () => {
	wp.ajax.send( 'bigbox-preview-css', {
		success: ( response ) => {
			// Update inline CSS.
			const selector = 'bigbox-inline-css';

			$( `#${ selector }` ).remove();

			$( '<div>', {
				id: selector,
				html: '&shy;<style>' + response.css + '</style>',
			} ).appendTo( 'body' );

			// Update web fonts.
			if ( response.fontFamily ) {
				WebFont.load( {
					google: {
						families: [ response.fontFamily ],
					},
				} );
			}
		},
	} );
};

// Wait for DOM ready.
( function() {
	// Wait for Preview ready.
	wp.customize.bind( 'preview-ready', () => {
		const controls = filter( Object.keys( wp.customize.settings.activeControls ), ( setting ) => {
			return setting.match( /color/i ) || setting.match( /type/i );
		} );

		// Refresh CSS when each control changes.
		forEach( controls, ( settingId ) => {
			wp.customize( settingId, ( settingObj ) => {
				settingObj.bind( debounce( updateCss, wp.customize.settings.timeouts.selectiveRefresh ) );
			} );
		} );
	} );
} );

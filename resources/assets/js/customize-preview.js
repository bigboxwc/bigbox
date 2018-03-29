/** global jQuery, wp */

/**
 * External dependencies.
 */
import { filter, forEach, debounce } from 'lodash';

(function( $ ){

	wp.customize.bind( 'preview-ready', () => {
		const colorControls = filter( Object.keys( wp.customize.settings.activeControls ), ( setting ) => {
			return setting.match( /color/i );
		} );

		/**
		 * Update inline CSS styles.
		 *
		 * @param {String} settingId  Setting ID.
		 * @param {Object} settingObj Setting object.
		 */
		const updateStyles = ( settingId, settingObj ) => {
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
				failure: () => {
					wp.customize.trigger( 'loading-failed' );
				}
			} );
		}

		forEach( colorControls, ( settingId ) => {
			// Get setting object from ID.
			wp.customize( settingId, ( settingObj ) => {

				// Bind an update (250ms debounce).
				settingObj.bind( debounce( ( to ) => {

					// Update inline styles.
					updateStyles( settingId, settingObj );
				}, wp.customize.settings.timeouts.selectiveRefresh ) );
			} );
		} );
	} );
})( jQuery );

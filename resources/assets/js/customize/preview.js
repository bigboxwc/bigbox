/* global WebFont, $, _ */

// Wait for Preview ready.
wp.customize.bind( 'preview-ready', () => {
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

	/**
	 * Filter color and type controls.
	 */
	const controls = _.filter( Object.keys( wp.customize.settings.activeControls ), ( setting ) => {
		return setting.match( /color/i ) || setting.match( /type/i );
	} );

	// Refresh CSS when each control changes.
	_.each( controls, ( settingId ) => {
		wp.customize( settingId, ( settingObj ) => {
			settingObj.bind( _.debounce( updateCss, wp.customize.settings.timeouts.selectiveRefresh ) );
		} );
	} );
} );

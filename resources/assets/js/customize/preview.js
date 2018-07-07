/* global WebFont, _ */

// Wait for Preview ready.
wp.customize.bind( 'preview-ready', () => {
	/**
	 * Update inline CSS and webfonts.
	 */
	const updateCss = () => {
		wp.ajax.send( 'bigbox-preview-css', {
			success: ( response ) => {
				const selector = 'bigbox-inline-css';

				// Remove old.
				document.getElementById( selector ).remove();

				// Create new and append.
				const newStyle = document.createElement( 'div' );

				newStyle.setAttribute( 'id', selector );
				newStyle.innerHTML = '&shy;<style>' + response.css + '</style>';

				document.body.append( newStyle );

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

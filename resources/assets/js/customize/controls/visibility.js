/* global wp, _ */

/**
 * External dependencies.
 */
import domReady from '@wordpress/dom-ready';

/**
 * Toggle other control's visibility based on another.
 */
domReady( () => {
	const api = wp.customize;

	// Control visibility for controls
	_.each( {
		// Hide WC Store notice controls if notice is disabled.
		woocommerce_demo_store: {
			controls: [
				'demo-store-notice-position',
				'demo-store-notice-color',
				'demo-store-notice-color-background',
			],
			callback: function( to ) {
				return !! to;
			},
		},
	}, ( o, settingId ) => {
		api( settingId, ( setting ) => {
			// Handle multiple toggles.
			_.each( o.controls, ( controlId ) => {
				// Toggle control.
				api.control( controlId, ( control ) => {
					const visibility = ( to ) => {
						control.container.toggle( o.callback( to ) );
					};

					visibility( setting.get() );

					setting.bind( visibility );
				} );
			} );
		} );
	} );
} );

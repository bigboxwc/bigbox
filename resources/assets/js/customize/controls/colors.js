/* global wp, wpColorPicker */

const { customize } = wp;

customize.controlConstructor[ 'color-better-palettes' ] = customize.ColorControl.extend( {
	/**
	 * Control is ready.
	 */
	ready: function() {
		const control = this;
		const { mode, palettes } = control.params;
		const isHueSlider = mode === 'hue';

		let updating = false;
		let picker;

		if ( isHueSlider ) {
			picker = control.container.find( '.color-picker-hue' );

			picker.val( control.setting() ).wpColorPicker( {
				palettes: palettes,

				/**
				 * Change event.
				 *
				 * @param {Object} event Change event.
				 * @param {Object} ui Colorpicker UI.
				 */
				change: ( event, ui ) => {
					updating = true;
					control.setting( ui.color.h() );
					updating = false;
				},
			} );
		} else {
			picker = control.container.find( '.color-picker-hex' );

			picker.val( control.setting() ).wpColorPicker( {
				palettes: palettes,

				/**
				 * Change event.
				 */
				change: () => {
					updating = true;
					control.setting.set( picker.wpColorPicker( 'color' ) );
					updating = false;
				},

				/**
				 * Clear event.
				 */
				clear: () => {
					updating = true;
					control.setting.set( '' );
					updating = false;
				},
			} );
		}

		control.setting.bind( ( value ) => {
			// Bail if the update came from the control itself.
			if ( updating ) {
				return;
			}

			picker.val( value );
			picker.wpColorPicker( 'color', value );
		} );

		/**
		 * Collapse color picker when hitting Esc instead of collapsing the current section.
		 *
		 * @param {Object} event Keydown event.
		 */
		control.container.on( 'keydown', ( event ) => {
			let pickerContainer = null;

			if ( 27 !== event.which ) { // Esc.
				return;
			}

			pickerContainer = control.container.find( '.wp-picker-container' );

			if ( pickerContainer.hasClass( 'wp-picker-active' ) ) {
				picker.wpColorPicker( 'close' );
				control.container.find( '.wp-color-result' ).focus();
				event.stopPropagation(); // Prevent section from being collapsed.
			}
		} );
	},
} );

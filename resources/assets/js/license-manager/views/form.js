/* global BigBoxLicenseManager, wp */

/**
 * Internal dependencies.
 */
import Base from './base.js';

/**
 * License form.
 */
const LicenseForm = Base.extend( {
	/**
	 * Template. Found in `resources/views/nux/steps/license-manager/form.php`
	 */
	template: wp.template( 'bigbox-license-manager-form' ),

	/**
	 * Bind events.
	 */
	events: {
		'submit form': 'submitForm',
	},

	/**
	 * Activate on load.
	 */
	initialize: function() {
		this.listenTo( this.model, 'change', this.render );

		this.activate( this.model.get( 'license' ) );
	},

	/**
	 * Handle form submission.
	 *
	 * @param {Object} e Event.
	 */
	submitForm: function( e ) {
		e.preventDefault();

		const license = this.$el.find( 'input' ).val();

		this.activate( license );
	},

	/**
	 * Attempt to activate a license.
	 *
	 * @param {string} license License.
	 */
	activate: function( license ) {
		this.model.set( 'isPending', true );
		this.model.set( 'license', license );

		wp.ajax.send( 'bigbox-license-request', {
			data: {
				license,
				edd_action: 'activate_license',
				_wpnonce: BigBoxLicenseManager.nonce,
			},
			success: ( response ) => {
				this.model.set( 'isValid', response.isValid );
				this.model.set( 'isPending', false );
			},
			error: () => {
				this.model.set( 'isValid', false );
				this.model.set( 'isPending', false );
			},
		} );
	},
} );

export default LicenseForm;

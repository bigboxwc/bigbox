/* global BigBoxLicenseManager, wp */

/**
 * Internal dependencies.
 */
import Base from './base.js';

/**
 * License deactivation.
 */
const LicenseDeactivate = Base.extend( {
	/**
	 * Template. Found in `resources/views/nux/steps/license-manager/deactivate.php`
	 */
	template: wp.template( 'bigbox-license-manager-deactivate' ),

	/**
	 * Wrapper.
	 */
	tagName: 'p',

	/**
	 * className.
	 */
	className: 'license-deactivate',

	/**
	 * Bind events.
	 */
	events: {
		'click button': 'deactivate',
	},

	/**
	 * Deactivate a license.
	 *
	 * @param {Object} e Event.
	 */
	deactivate: function( e ) {
		e.preventDefault();

		this.model.set( 'isPending', true );

		wp.ajax.send( 'bigbox-license-request', {
			data: {
				license: this.model.get( 'license' ),
				edd_action: 'deactivate_license',
				_wpnonce: BigBoxLicenseManager.nonce,
			},
			success: () => {
				this.model.set( 'isValid', false );
				this.model.set( 'license', '' );
				this.model.set( 'isPending', false );
			},
		} );
	},
} );

export default LicenseDeactivate;

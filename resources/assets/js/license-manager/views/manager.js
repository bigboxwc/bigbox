/* global $, wp */

/**
 * Internal dependencies.
 */
import LicenseForm from './form.js';
import LicenseStatus from './status.js';
import LicenseDeactivate from './deactivate.js';

/**
 * License Manager container.
 */
const LicenseManager = wp.Backbone.View.extend( {
	el: $( '#bigbox-license-manager' ),

	/**
	 * Render.
	 */
	render: function() {
		// Add main form.
		this.views.add( new LicenseForm( {
			model: this.model,
		} ) );

		// Add status text.
		this.views.add( new LicenseStatus( {
			model: this.model,
		} ) );

		// Add deactivate button.
		this.views.add( new LicenseDeactivate( {
			model: this.model,
		} ) );
	},
} );

export default LicenseManager;

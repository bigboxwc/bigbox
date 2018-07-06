/* global Backbone */

/**
 * External dependencies.
 */
import classNames from 'classnames';

/**
 * License.
 */
const License = Backbone.Model.extend( {
	/**
	 * Set default attributes.
	 *
	 * `status` and `className` are dynamically generated based on other attributes.
	 *
	 * @return {Object} Model attributes.
	 */
	defaults: function() {
		// Class names to be used on input and status.
		return {
			license: BigBoxLicenseManager.local.license,
			isValid: BigBoxLicenseManager.local.isValid,
			isPending: false,
		};
	},

	status: function() {
		const { licenseValid, licenseInvalid } = BigBoxLicenseManager.i18n;

		return this.get( 'isValid' ) ? licenseValid : licenseInvalid;
	},

	className: function() {
		return classNames(
			'license',
			{
				[ `license--status-${ this.get( 'isValid' ) ? 'valid' : 'invalid' }` ]: ! this.get( 'isPending' ),
			},
		);
	},
} );

export default License;

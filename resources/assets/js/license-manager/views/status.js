/* global wp */

/**
 * Internal dependencies.
 */
import Base from './base.js';

/**
 * License status.
 */
const LicenseStatus = Base.extend( {
	/**
	 * Template. Found in `resources/views/nux/steps/license-manager/status.php`
	 */
	template: wp.template( 'bigbox-license-manager-status' ),

	/**
	 * Wrapper.
	 */
	tagName: 'p',

	/**
	 * className.
	 */
	className: 'license-status',
} );

export default LicenseStatus;

/* global BigBoxLicenseManager */

/**
 * Internal dependencies.
 */
import License from './models/license.js';
import LicenseManager from './views/manager.js';

// Init manager.
const licenseManager = new LicenseManager( {
	model: new License( BigBoxLicenseManager.local ),
} );

licenseManager.render();

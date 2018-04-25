/* global BigBoxLicenseManager, wp, wpApiSettings */

/**
 * Internal dependencies.
 */
import {
	LICENSE_REQUEST,
	LICENSE_REQUEST_SUCCESS,
	LICENSE_REQUEST_FAILURE,
} from './reducer';

/**
 * Save a license option.
 *
 * @param {string} license License to save.
 * @param {string} licenseStatus License status. valid or invalid.
 */
function saveLicense( license, licenseStatus ) {
	wp.ajax.send( 'bigbox-license-request', {
		url: `${ wpApiSettings.root }${ wpApiSettings.versionString }settings`,
		method: 'POST',
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce,
		},
		data: {
			bigbox_license: license,
			bigbox_license_status: licenseStatus,
		},
	} );
}

/**
 * Attempt to activate a license.
 *
 * @param  {string}   license License
 * @return {Function} Action thunk
 */
export function activateLicense( license = '' ) {
	return ( dispatch ) => {
		dispatch( {
			type: LICENSE_REQUEST,
			license,
		} );

		wp.ajax.send( 'bigbox-license-request', {
			data: {
				edd_action: 'activate_license',
				license: license,
				_wpnonce: BigBoxLicenseManager.nonce,
			},
			success: ( response ) => {
				const args = {
					type: LICENSE_REQUEST_SUCCESS,
					license,
				};

				if ( 'valid' === response.license ) {
					args.validLicense = true;
				} else {
					args.validLicense = false;
				}

				dispatch( args );
				saveLicense( license, response.license );
			},
			error: () => {
				dispatch( {
					type: LICENSE_REQUEST_FAILURE,
				} );

				saveLicense( '' );
			},
		} );
	};
}

/**
 * Attempt to deactivate a license.
 *
 * @param  {string}   license License
 * @return {Function} Action thunk
 */
export function deactivateLicense( license = '' ) {
	return ( dispatch ) => {
		dispatch( {
			type: LICENSE_REQUEST,
			license,
		} );

		wp.ajax.send( 'bigbox-license-request', {
			data: {
				edd_action: 'deactivate_license',
				license: license,
				_wpnonce: BigBoxLicenseManager.nonce,
			},
			success: () => {
				const args = {
					type: LICENSE_REQUEST_FAILURE,
					license: '',
					validLicense: false,
				};

				dispatch( args );

				saveLicense( '', 'deactivated' );
			},
			error: () => {
				dispatch( {
					type: LICENSE_REQUEST_FAILURE,
				} );

				saveLicense( '' );
			},
		} );
	};
}

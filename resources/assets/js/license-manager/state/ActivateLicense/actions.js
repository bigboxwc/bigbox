/**
 * External dependencies.
 */
import axios from 'axios';

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
 * @param {String} licenses License to save.
 */
function saveLicense(license, licenseStatus) {
	axios({
		url: `${wpApiSettings.root}${wpApiSettings.versionString}settings`,
		method: 'POST',
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce
		},
		params: {
			'bigbox_license': license,
			'bigbox_license_status': licenseStatus,
		}
	});
}

/**
 * Attempt to activate a license.
 *
 * @param  {String}   license License
 * @return {Function} Action thunk
 */
export function activateLicense(license = '') {
	return (dispatch) => {
		dispatch({
			type: LICENSE_REQUEST,
		});

		axios.get(BigBoxLicenseManager.remote.apiRoot, {
			params: {
				edd_action: 'activate_license',
				license: license,
				item_name: encodeURIComponent(BigBoxLicenseManager.remote.itemName),
				url: BigBoxLicenseManager.local.domain,
			}
		})
			.then((response) => {
				const args = {
						type: LICENSE_REQUEST_SUCCESS,
				}

				if ('valid' === response.data.license) {
					args['license']      = license;
					args['validLicense'] = true;

					// Remove count in menu.
					$('#toplevel_page_bigbox .update-plugins' ).remove();
				} else {
					args['license']      = '';
					args['validLicense'] = false;
				}

				dispatch(args);
				saveLicense(license, response.data.license);
			})
			.catch((response) => {
				dispatch({
					type: LICENSE_REQUEST_FAILURE,
				});

				saveLicense('');
			});
	}
}

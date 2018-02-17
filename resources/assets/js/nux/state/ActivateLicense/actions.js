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
function saveLicense(license) {
	axios({
		url: `${wpApiSettings.root}${wpApiSettings.versionString}settings`,
		method: 'POST',
		headers: {
			'X-WP-Nonce': wpApiSettings.nonce
		},
		params: {
			'bigbox_license': license,
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

		axios.get('https://bigbox.dev', {
			params: {
				edd_action: 'activate_license',
				license: license,
				item_name: encodeURIComponent(BigBoxNUX.itemName),
				url: BigBoxNUX.domain,
			}
		})
			.then((response) => {
				if ('valid' === response.data.license) {
					dispatch({
						type: LICENSE_REQUEST_SUCCESS,
						license,
						validLicense: true,
					});
				} else {
					dispatch({
						type: LICENSE_REQUEST_SUCCESS,
						license: '',
						validLicense: false,
					});
				}

				saveLicense(license);
			})
			.catch((response) => {
				dispatch({
					type: LICENSE_REQUEST_FAILURE,
				});

				saveLicense('');
			});
	}
}

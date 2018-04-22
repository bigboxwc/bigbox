/* global BigBoxLicenseManager */

/**
 * External dependencies.
 */
import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';

/**
 * Internal dependencies.
 */
import configureStore from './state';
import ActivateLicense from './components/ActivateLicense.js';

/**
 * NUX.
 *
 * @return {Object} Provider component.
 */
const NUX = () => (
	<Provider store={ configureStore() }>
		<ActivateLicense
			license={ BigBoxLicenseManager.local.license }
		/>
	</Provider>
);

ReactDOM.render(
	<NUX />,
	document.getElementById( 'bigbox-license-manager' )
);

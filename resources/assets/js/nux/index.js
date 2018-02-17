/**
 * External dependencies.
 */
import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';

/**
 * Internal dependencies.
 */
import configureStore from './store';
import ActivateLicense from './activate-license.js';

const NUX = () => (
	<Provider store={configureStore()}>
		<ActivateLicense />
	</Provider>
);

ReactDOM.render(
	<NUX />,
	document.getElementById('bigbox-activate-license')
);

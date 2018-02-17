/**
 * External dependencies.
 */
import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';

/**
 * Internal dependencies.
 */
import '../../scss/nux.scss';
import configureStore from './state';
import ActivateLicense from './components/ActivateLicense.js';

const NUX = () => (
	<Provider store={configureStore()}>
		<ActivateLicense
      license={BigBoxNUX.license}
    />
	</Provider>
);

ReactDOM.render(
	<NUX />,
	document.getElementById('bigbox-activate-license')
);

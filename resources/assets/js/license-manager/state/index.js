/**
 * External dependencies.
 */
import { createStore, applyMiddleware } from 'redux';
import thunkMiddleware from 'redux-thunk';

/**
 * Internal dependencies.
 */
import { activateLicense } from './ActivateLicense/reducer';

/**
 * Configure store.
 *
 * @return {Object} Store.
 */
const configureStore = () => createStore(
	activateLicense,
	applyMiddleware( thunkMiddleware ),
);

export default configureStore;

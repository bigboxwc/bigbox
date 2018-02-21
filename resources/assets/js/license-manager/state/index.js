/**
 * External dependencies.
 */
import { createStore, applyMiddleware, combineReducers } from 'redux';
import thunkMiddleware from 'redux-thunk';

/**
 * Internal dependencies.
 */
import { activateLicense } from './ActivateLicense/reducer';

const configureStore = () => createStore(
	activateLicense,
	applyMiddleware( thunkMiddleware ),
);

export default configureStore;

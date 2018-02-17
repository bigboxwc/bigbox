import { createStore, applyMiddleware, combineReducers } from 'redux';
import thunkMiddleware from 'redux-thunk';

function reducer(state) {
	return state;
};

const configureStore = () => createStore(
  reducer,
  applyMiddleware(thunkMiddleware),
);

export default configureStore;

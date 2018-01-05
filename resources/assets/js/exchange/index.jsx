import React from 'react';
import ReactDOM from "react-dom";
import {createStore} from "redux";
import {Provider} from 'react-redux';
import allReducers from './reducers';
import Exchange from './containers/Exchange';

const store = createStore(
	allReducers
);


ReactDOM.render(
	<Provider store={store}>
		<Exchange/>
	</Provider>,
	document.getElementById('root')
);
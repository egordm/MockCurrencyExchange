import React from 'react';
import ReactDOM from "react-dom";

import {applyMiddleware, createStore} from "redux";
import {Provider} from 'react-redux';

import logger from 'redux-logger';
import thunk from 'redux-thunk'
import promise from 'redux-promise-middleware';
import sequenceAction from 'redux-sequence-action';
import axios from 'axios';
import axiosMiddleware from 'redux-axios-middleware';

import reducer from './reducers';
import Exchange from './containers/Exchange';

const client = axios.create({ //all axios can be used, shown in axios documentation
	baseURL: '/api',
	responseType: 'json'
});

const middleware = applyMiddleware(/*logger, */promise(), thunk, sequenceAction, axiosMiddleware(client));
const store = createStore(reducer, middleware);


ReactDOM.render(<Provider store={store}><Exchange/></Provider>, document.getElementById('root'));
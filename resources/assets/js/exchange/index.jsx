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
import createSagaMiddleware from 'redux-saga'

import reducer from './reducers';
import Exchange from './containers/Exchange';

import pollMarketSaga from './sagas/saga-poll-exchange';
import pollUserSaga from './sagas/saga-poll-user';

const client = axios.create({ //all axios can be used, shown in axios documentation
	responseType: 'json'
});

const sagaMiddleware = createSagaMiddleware();

const middleware = applyMiddleware(/*logger,*/ promise(), thunk, sequenceAction, axiosMiddleware(client), sagaMiddleware);
const store = createStore(reducer, middleware);

sagaMiddleware.run(pollMarketSaga);
sagaMiddleware.run(pollUserSaga);

ReactDOM.render(<Provider store={store}><Exchange/></Provider>, document.getElementById('root'));
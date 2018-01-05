import React from 'react';
import ReactDOM from "react-dom";

import {applyMiddleware, createStore} from "redux";
import {Provider} from 'react-redux';
import logger from 'redux-logger';
import promise from 'redux-promise-middleware';

import reducer from './reducers';
import Exchange from './containers/Exchange';


const middleware = applyMiddleware(logger, promise());
const store = createStore(reducer, middleware);


ReactDOM.render(<Provider store={store}><Exchange/></Provider>, document.getElementById('root'));